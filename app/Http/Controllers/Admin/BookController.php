<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // TODO: Lấy danh sách sách kèm thông tin Author và Category (Eager Loading)
        // TODO: Phân trang 10-15 dòng/trang
        return view('admin.books.index',compact('books'));
    }

    public function create()
    {
        // TODO: Lấy danh sách Author và Category để đổ vào thẻ <select> trong form
        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        // TODO: Sử dụng StoreBookRequest để validate
        // TODO: Xử lý Upload ảnh bìa (AnhBia) vào thư mục storage/uploads
        // TODO: Lưu vào bảng 'sach'
        return redirect()->route('books.index')->with('success', 'Thêm sách mới thành công!');
    }

    public function edit($id)
    {
        // TODO: Tìm sách theo ID, nếu không có trả về 404
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // TODO: Cập nhật thông tin sách
        // TODO: Nếu có ảnh mới thì xóa ảnh cũ và cập nhật ảnh mới
        return redirect()->route('books.index')->with('success', 'Cập nhật sách thành công!');
    }

    public function destroy($id)
    {
        // TODO: Xóa sách (Lưu ý: Kiểm tra nếu sách đã có trong đơn hàng thì không cho xóa hoặc dùng Soft Delete)
        return redirect()->route('books.index')->with('success', 'Đã xóa sách khỏi hệ thống!');
    }
}