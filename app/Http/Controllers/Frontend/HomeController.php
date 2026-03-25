<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    #public function index()
    #{
        // TODO: Lấy 8 quyển sách mới nhất (sắp xếp theo ID giảm dần)
        // TODO: Lấy danh sách thể loại để hiển thị menu
        // TODO: Trả về view 'frontend.home.index' kèm dữ liệu
        #return view('frontend.home.index');
    #}

    # Đây là code để test giao diện
    public function index() {
    $sach_list = Book::where('TrangThai', 'active')->take(8)->get();
        return view('frontend.home', compact('sach_list'));
}
}