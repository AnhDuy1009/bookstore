<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Lấy danh sách đánh giá, phân trang 10 dòng
        $reviews = Review::with(['book', 'user'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['TrangThai' => 'approved']); // Duyệt đánh giá
        return redirect()->back()->with('success', 'Đã duyệt đánh giá thành công!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete(); // Xóa đánh giá
        return redirect()->back()->with('success', 'Đã xóa đánh giá khỏi hệ thống!');
    }
}