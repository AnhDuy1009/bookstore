<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review; // Thêm dòng này để gọi Model Review
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::paginate(12);
        $categories = Category::all(); 
        return view('frontend.books.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        // 1. Lấy thông tin cuốn sách hiện tại
        $book = Book::with(['tacGia', 'danhMuc'])->findOrFail($id);

        // (Tùy chọn) Tăng lượt xem
        $book->increment('LuotXem');

        // 2. LẤY DANH SÁCH ĐÁNH GIÁ CỦA CUỐN SÁCH NÀY
        // Lấy các đánh giá có IDSach khớp, kèm thông tin người dùng (user), sắp xếp mới nhất lên đầu
        $reviews = Review::with('user')
                        ->where('IDSach', $id)
                        ->where('TrangThai', 'active')
                        ->orderBy('NgayDanhGia', 'desc')
                        ->get();

        // 3. LẤY DANH SÁCH "SÁCH CÙNG THỂ LOẠI"
        $relatedBooks = Book::where('IDDanhMuc', $book->IDDanhMuc)
                            ->where('ID', '!=', $book->ID)
                            ->take(4)
                            ->get();

        // 4. Gửi các biến sang cho giao diện (View) - Nhớ thêm 'reviews' vào đây
        return view('frontend.books.show', compact('book', 'relatedBooks', 'reviews'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $books = Book::where('TenSach', 'LIKE', "%{$keyword}%")->paginate(12);
        return view('frontend.books.index', compact('books', 'keyword'));
    }

    public function bestseller()
    {
        $books = Book::orderBy('LuotXem', 'desc')->take(10)->get();
        return view('frontend.books.bestseller', compact('books'));
    }

    public function filterByCategory($categoryId)
    {
        $books = Book::where('IDDanhMuc', $categoryId)->paginate(12);
        return view('frontend.books.index', compact('books'));
    }
    
}