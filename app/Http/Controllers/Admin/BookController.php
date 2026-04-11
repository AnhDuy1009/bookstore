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
        // TODO: Lấy danh sách sách kèm thông tin Author và Category
       $books = \App\Models\Book::orderBy('ID', 'desc')->paginate(10);

        // Truyền biến $books sang view admin.books.index
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = \App\Models\Author::all(); 
        $categories = \App\Models\Category::all();

        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        // TODO: Sử dụng StoreBookRequest để validate
        // TODO: Xử lý Upload ảnh bìa (AnhBia) vào thư mục storage/uploads
        // TODO: Lưu vào bảng 'sach'
        return redirect()->route('admin.books.index')->with('success', 'Thêm sách mới thành công!');
    }

    public function edit($id)
    {
        $book = \App\Models\Book::findOrFail($id);

        
        $authors = \App\Models\Author::all(); 
        $categories = \App\Models\Category::all();

        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // 1. Tìm cuốn sách trong Database
        $book = \App\Models\Book::findOrFail($id);

        // 2. Cập nhật dữ liệu từ form gửi lên (Lấy theo thuộc tính name="..." trong file HTML)
        if ($request->has('TenSach')) $book->TenSach = $request->input('TenSach');
        if ($request->has('GiaBan')) $book->GiaBan = $request->input('GiaBan');
        if ($request->has('TrangThai')) $book->TrangThai = $request->input('TrangThai');
        if ($request->has('MoTa')) $book->MoTa = $request->input('MoTa');

        // 3. Lệnh quan trọng nhất: Lưu đè xuống Database
        $book->save();

        // 4. Trở về trang quản lý và báo thành công
        return redirect()->route('admin.books.index')->with('success', 'Cập nhật sách thành công!');
    }

    public function destroy($id)
    {
        // TODO: Xóa sách (Lưu ý: Kiểm tra nếu sách đã có trong đơn hàng thì không cho xóa hoặc dùng Soft Delete)
        return redirect()->route('admin.books.index')->with('success', 'Đã xóa sách khỏi hệ thống!');
    }
}