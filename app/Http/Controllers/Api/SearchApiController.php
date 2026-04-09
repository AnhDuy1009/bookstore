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

        // Nếu từ khóa quá ngắn, trả về mảng rỗng để tránh truy vấn nặng
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        // 1. Truy vấn bảng 'sach' theo 'TenSach' LIKE %keyword%
        // 2. Lấy tối đa 8 kết quả (con số lý tưởng cho dropdown)
        // 3. Chỉ lấy các cột cần thiết để tối ưu hiệu năng
        $results = Book::select('ID', 'TenSach', 'Link_Anh_Bia', 'GiaBan')
            ->where('TenSach', 'LIKE', '%' . $keyword . '%')
            ->where('TrangThai', 'Active') // Chỉ lấy sách đang bán
            ->take(8)
            ->get()
            ->map(function ($book) {
                // Xử lý logic hiển thị ảnh giống như ngoài Blade
                $imagePath = \Illuminate\Support\Str::contains($book->Link_Anh_Bia, 'http') 
                    ? $book->Link_Anh_Bia 
                    : asset('storage/' . $book->Link_Anh_Bia);

                return [
                    'id' => $book->ID,
                    'title' => $book->TenSach,
                    'price' => number_format($book->GiaBan) . 'đ',
                    'image' => $imagePath,
                    'url' => route('books.show', $book->ID) // Đường dẫn chi tiết sách
                ];
            });

        // Trả về JSON kết quả
        return response()->json($results);
    }
}