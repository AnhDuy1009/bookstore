<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Book; // Gọi Model Book của bạn vào đây

class CartService
{
    // Lấy toàn bộ giỏ hàng từ Session
    public function get()
    {
        return Session::get('cart', []);
    }

    // Thêm sản phẩm vào giỏ
    public function add($id, $quantity = 1)
    {
        $cart = $this->get();

        // Nếu sách đã có trong giỏ, thì chỉ cần cộng dồn số lượng
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Nếu chưa có, tìm sách trong Database
            // Lưu ý: Tên model có thể là Book hoặc SanPham tùy bạn đặt nhé
            $book = Book::find($id); 
            
            if (!$book) {
                return false; // Không tìm thấy sách
            }

            // Thêm sách mới vào mảng giỏ hàng (khớp với các biến bạn dùng ngoài View)
            $cart[$id] = [
                'title' => $book->TenSach,          // Cột tên sách trong DB của bạn
                'price' => $book->GiaBan,           // Cột giá bán trong DB
                'image' => $book->Link_Anh_Bia,     // Cột link ảnh trong DB
                'quantity' => $quantity
            ];
        }

        // Lưu mảng giỏ hàng ngược lại vào Session
        Session::put('cart', $cart);
        return true;
    }

    // Cập nhật số lượng
    public function update($id, $quantity)
    {
        $cart = $this->get();
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $quantity); // Ép số lượng nhỏ nhất là 1
            Session::put('cart', $cart);
        }
    }

    // Xóa 1 sản phẩm
    public function remove($id)
    {
        $cart = $this->get();
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
    }

    // Làm sạch giỏ hàng (Xóa tất cả)
    public function clear()
    {
        Session::forget('cart');
    }

    // Tính tổng tiền giỏ hàng
    public function getTotalPrice()
    {
        $cart = $this->get();
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }
        return $total;
    }
}