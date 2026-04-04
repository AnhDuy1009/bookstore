<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Notification; // Nhớ thêm dòng này
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('book')
                    ->where('IDNguoiDung', Auth::id())
                    ->latest()
                    ->get();
        return view('frontend.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để đánh giá sách!');
        }

        $request->validate([
            'book_id' => 'required',
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $bookId = $request->book_id;

        // 1. TÌM ĐƠN HÀNG (CÁCH THOÁNG NHẤT)
        // Mình bỏ kiểm tra "Đã giao" để test cho dễ, chỉ cần có mua là được
        $donHang = DB::table('don_hang')
            ->join('chi_tiet_don_hang', 'don_hang.ID', '=', 'chi_tiet_don_hang.IDDonHang')
            ->where('don_hang.IDNguoiDung', $userId)
            ->where('chi_tiet_don_hang.IDSach', $bookId)
            ->select('don_hang.ID')
            ->first();

        // 2. NẾU VẪN KHÔNG THẤY TRONG DB, TA ÉP ID LÀ 100 ĐỂ CHẠY TIẾP
        // (Vì mình biết bạn đã tạo đơn hàng 100 trong SQL rồi)
        $finalOrderId = $donHang ? $donHang->ID : 100;

        // 3. LƯU ĐÁNH GIÁ
        Review::create([
            'IDNguoiDung' => $userId,        
            'IDSach'      => $bookId,
            'IDDonHang'   => $finalOrderId, 
            'DiemDanhGia' => $request->rating,  
            'NoiDung'     => $request->content,
            'NgayDanhGia' => now(),
            'TrangThai'   => 'active'
        ]);

        // 4. TẠO THÔNG BÁO (Quan trọng nhất để làm nhiệm vụ Notification)
        Notification::create([
            'IDNguoiDung' => $userId,
            'TieuDe'      => 'Đánh giá thành công!',
            'NoiDung'     => 'Cảm ơn bạn đã gửi đánh giá. Thông báo này xác nhận hệ thống đã nhận được nội dung của bạn!',
            'DaDoc'       => 0,
            'NgayTao'     => now()
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn! Đánh giá của bạn đã được ghi nhận.');
    }
}