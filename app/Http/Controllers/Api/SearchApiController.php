<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->get('query');
        // TODO: Truy vấn bảng 'sach' theo 'TenSach' LIKE %keyword%
        // TODO: Lấy tối đa 5-10 kết quả kèm AnhBia và GiaBan
        // TODO: Trả về JSON kết quả để JS hiển thị dropdown kết quả nhanh
    }
}