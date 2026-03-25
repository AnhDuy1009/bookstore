<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // TODO: Xử lý lọc sách theo Category (IDDanhMuc) nếu có request
        // TODO: Xử lý tìm kiếm sách theo tên (TenSach)
        // TODO: Phân trang (paginate) mỗi trang 12 quyển
        // TODO: Lấy danh sách sách có phân trang
        $books = Book::paginate(12);

        // THÊM DÒNG NÀY: Lấy tất cả thể loại để hiện ở Sidebar
        // TODO: Query lấy toàn bộ dữ liệu từ bảng danh_muc
        $categories = Category::all(); 

        // Truyền cả 2 biến books và categories ra ngoài
        return view('frontend.books.index', compact('books', 'categories'));
       
    }

    public function show($id)
    {
        // TODO: Tìm sách theo ID, nếu không thấy trả về 404
        // TODO: Lấy các sách liên quan (cùng IDDanhMuc)
        // TODO: Lấy danh sách đánh giá (reviews) của sách này
        return view('frontend.books.show');
    }

    /**
     * TODO: Xử lý tìm kiếm sách
     * Nhiệm vụ:
     * - Nhận từ khóa từ request (ví dụ: $request->q)
     * - Truy vấn SQL: WHERE TenSach LIKE %từ_khóa%
     * - Trả về view 'frontend.books.index' kèm danh sách kết quả
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        // Gợi ý logic:
        // $books = Book::where('TenSach', 'LIKE', "%{$keyword}%")
        //             ->where('TrangThai', 'active')
        //             ->paginate(12);

        return view('frontend.books.index', compact('books', 'keyword'));
    }

    /**
     * TODO 2: Xử lý danh sách sách bán chạy (Bestseller)
     * Nhiệm vụ:
     * - Truy vấn những cuốn sách có số lượt mua nhiều nhất
     * - Gợi ý: Join bảng 'sach' với bảng 'chi_tiet_don_hang' và SUM(SoLuong)
     * - Hoặc đơn giản: Sắp xếp theo cột 'LuotXem' hoặc 'TongBan' nếu có sẵn
     */
    public function bestseller()
    {
        // Gợi ý logic:
        // $books = Book::orderBy('LuotXem', 'desc')->take(10)->get();

         return view('frontend.books.bestseller', compact('books'));
        
    }

    /**
     * TODO 3: Xử lý lọc theo danh mục (Sidebar)
     * Nhiệm vụ:
     * - Nhận ID danh mục từ URL
     * - Lấy ra toàn bộ sách thuộc danh mục đó
     */
    public function filterByCategory($categoryId)
    {
        // $books = Book::where('IDDanhMuc', $categoryId)->paginate(12);
        
        return view('frontend.books.index', compact('books'));
        
     
    }
}