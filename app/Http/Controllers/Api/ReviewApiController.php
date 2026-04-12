<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewApiController extends Controller
{
    public function store(Request $request)
    {
        // 1. Kiểm tra User đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện đánh giá.'
            ], 401);
        }

        // 2. Validate dữ liệu đầu vào theo cấu trúc bảng thực tế
        $validator = Validator::make($request->all(), [
            'IDSach'      => 'required|exists:sach,ID',
            'IDDonHang'   => 'required|exists:don_hang,ID',
            'NoiDung'     => 'required|string|min:5',
            'DiemDanhGia' => 'required|integer|min:1|max:5',
            'HinhAnh'     => 'nullable|string', // Nếu bạn gửi link ảnh từ Client
        ], [
            'NoiDung.required' => 'Vui lòng nhập nội dung đánh giá.',
            'NoiDung.min'      => 'Nội dung phải có ít nhất 5 ký tự.',
            'DiemDanhGia.required' => 'Vui lòng chọn số sao đánh giá.',
            'IDSach.exists'    => 'Sách không tồn tại.',
            'IDDonHang.exists' => 'Đơn hàng không tồn tại.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // 3. Lưu đánh giá mới dựa trên $fillable của Model Review
            $review = new Review();
            $review->IDNguoiDung = Auth::id();
            $review->IDSach      = $request->IDSach;
            $review->IDDonHang   = $request->IDDonHang;
            $review->NoiDung     = $request->NoiDung;
            $review->DiemDanhGia = $request->DiemDanhGia;
            $review->HinhAnh     = $request->HinhAnh;
            $review->NgayDanhGia = now(); // Sử dụng cột NgayDanhGia thay vì created_at
            $review->TrangThai   = 'active'; // Mặc định là active như file SQL
            $review->save();

            // 4. Trả về JSON chứa nội dung để hiển thị ngay trên giao diện
            return response()->json([
                'success' => true,
                'message' => 'Đánh giá của bạn đã được gửi thành công!',
                'data'    => [
                    'userName'    => Auth::user()->HoTen, // Lấy từ bảng nguoi_dung
                    'noiDung'     => $review->NoiDung,
                    'diemDanhGia' => $review->DiemDanhGia,
                    'ngayDanhGia' => date('d/m/Y H:i', strtotime($review->NgayDanhGia)),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình lưu: ' . $e->getMessage()
            ], 500);
        }
    }
}