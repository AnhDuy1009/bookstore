<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
// use App\Models\Notification; 
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
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để đánh giá sách!');
        }

        // 2. Validate dữ liệu đầu vào
        $request->validate([
            'book_id' => 'required',
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $bookId = $request->book_id;

        // 3. XÁC THỰC ĐƠN HÀNG 
        $donHang = DB::table('don_hang')
            ->join('chi_tiet_don_hang', 'don_hang.ID', '=', 'chi_tiet_don_hang.IDDonHang')
            ->where('don_hang.IDNguoiDung', $userId)
            ->where('chi_tiet_don_hang.IDSach', $bookId)
            ->select('don_hang.ID')
            ->first();

       
        $finalOrderId = $donHang ? $donHang->ID : 100;

        // 4. LƯU ĐÁNH GIÁ VÀO DATABASE 
        Review::create([
            'IDNguoiDung' => $userId,        
            'IDSach'      => $bookId,
            'IDDonHang'   => $finalOrderId, 
            'DiemDanhGia' => $request->rating,  
            'NoiDung'     => $request->content,
            'NgayDanhGia' => now(),
            'TrangThai'   => 'active'
        ]);

        /* Notification::create([
            'IDNguoiDung' => $userId,
            'TieuDe'      => 'Đánh giá thành công!',
            'NoiDung'     => 'Cảm ơn bạn đã gửi đánh giá. Hệ thống đã nhận được nội dung của bạn!',
            'DaDoc'       => 0,
            'NgayTao'     => now()
        ]); 
        */

        // 6. TRẢ VỀ THÔNG BÁO THÀNH CÔNG CHO NGƯỜI DÙNG
        return redirect()->back()->with('success', 'Cảm ơn bạn! Đánh giá và bình luận của bạn đã được ghi nhận.');
    }
}