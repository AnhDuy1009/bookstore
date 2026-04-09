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
    // 1. Tạo Query Builder từ Model Book
    $query = Book::with(['tacGia', 'danhMuc'])->where('TrangThai', 'Active');

    // 2. Xử lý tìm kiếm (từ khóa q)
    if ($request->filled('q')) {
        $keyword = $request->q;
        $query->where('TenSach', 'LIKE', "%{$keyword}%");
    }

    // 3. Xử lý lọc theo danh mục
    if ($request->filled('category')) {
        $query->where('IDDanhMuc', $request->category);
    }

    // 4. Xử lý lọc theo giá
    if ($request->filled('min_price')) {
        $query->where('GiaBan', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('GiaBan', '<=', $request->max_price);
    }

    // 5. Thực thi và phân trang
    $books = $query->orderBy('ID', 'desc')->paginate(12);

    // 6. Lấy danh sách thể loại cho Sidebar
    $categories = Category::where('TrangThai', 'Active')->get();

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

    public function bestseller(Request $request)
{
    // 1. Lấy danh sách thể loại để hiển thị ở Sidebar (Aside)
    $categories = \App\Models\Category::where('TrangThai', 'Active')->get();

    // 2. Khởi tạo Query lọc sách có LuotXem > 10,000
    $query = Book::with(['tacGia'])
                 ->where('LuotXem', '>', 10000)
                 ->where('TrangThai', 'Active');

    // 3. Xử lý các bộ lọc từ Sidebar (Nếu người dùng tìm kiếm trong trang Bán chạy)
    if ($request->filled('q')) {
        $query->where('TenSach', 'LIKE', '%' . $request->q . '%');
    }
    if ($request->filled('category')) {
        $query->where('IDDanhMuc', $request->category);
    }
    if ($request->filled('min_price')) {
        $query->where('GiaBan', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('GiaBan', '<=', $request->max_price);
    }

    // 4. Sắp xếp theo lượt xem cao nhất và phân trang
    $books = $query->orderBy('LuotXem', 'desc')->paginate(12);

    return view('frontend.books.bestseller', compact('books', 'categories'));
}

    public function filterByCategory($categoryId)
    {
        $books = Book::where('IDDanhMuc', $categoryId)->paginate(12);
        return view('frontend.books.index', compact('books'));
    }
    
}
