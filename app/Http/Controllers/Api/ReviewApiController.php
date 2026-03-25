<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Auth;

class ReviewApiController extends Controller
{
    public function store(Request $request)
    {
        // TODO: Kiểm tra User đã đăng nhập chưa (Auth::guard('api')->check())
        // TODO: Lưu đánh giá mới vào bảng 'danh_gia'
        // TODO: Trả về JSON chứa nội dung đánh giá vừa tạo để JS chèn vào danh sách hiển thị ngay
    }
}