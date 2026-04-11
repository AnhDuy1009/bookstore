<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
       
        $reviews = Review::with(['book', 'user'])
            ->orderBy('ID', 'desc')
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);

        $review->TrangThai = 'approved';
        $review->save();

        return redirect()->back()->with('success', 'Đã duyệt đánh giá của khách hàng thành công!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Xóa vĩnh viễn đánh giá khỏi hệ thống
        $review->delete();

        return redirect()->back()->with('success', 'Đã xóa đánh giá khỏi hệ thống!');
    }
}