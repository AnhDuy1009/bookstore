<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Session;

class CartService
{
    // TODO: Viết hàm get() để lấy toàn bộ giỏ hàng từ Session
    public function get() {
        return Session::get('cart', []);
    }

    // TODO: Viết hàm add($bookId, $quantity) 
    // - Kiểm tra xem sách có tồn tại và đủ SoLuong trong DB không
    // - Nếu đã có trong giỏ thì cộng dồn số lượng
    
    // TODO: Viết hàm update($bookId, $quantity)
    // - Cập nhật lại số lượng chính xác khi user thay đổi ở trang giỏ hàng

    // TODO: Viết hàm remove($bookId)
    // - Xóa cuốn sách khỏi giỏ hàng Session

    // TODO: Viết hàm getTotalPrice()
    // - Tính tổng tiền dựa trên (SoLuong * GiaBan) của từng mục
}