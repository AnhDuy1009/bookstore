<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách sách theo danh mục
     */
    public function show($id)
    {
        // 1. Lấy thông tin danh mục hiện tại (Khớp với ID trong bảng danh_muc)
        $the_loai_dang_chon = Category::where('TrangThai', 'Active')->findOrFail($id);

        // 2. Lấy danh sách sách thuộc danh mục này (Khớp với IDDanhMuc trong bảng sach)
        // Eager load 'tacGia' để hiển thị tên tác giả ở book_item mà không bị lỗi N+1
        $sach_theo_loai = Book::with('tacGia')
            ->where('IDDanhMuc', $id)
            ->where('TrangThai', 'Active')
            ->orderBy('ID', 'desc')
            ->paginate(12); // Phân trang 12 cuốn mỗi trang

        // 3. Lấy lại danh sách tất cả thể loại để hiển thị menu bên cạnh (nếu cần)
        $the_loai = Category::where('TrangThai', 'Active')->get();

        // 4. Trả về view: frontend/books/index.blade.php (Dùng chung giao diện danh sách sách)
        return view('frontend.books.index', compact('the_loai_dang_chon', 'sach_theo_loai', 'the_loai'));
    }
}