<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    // TODO: Khởi tạo CartService trong __construct

    public function index()
    {
        // TODO: Lấy toàn bộ sản phẩm từ session/service
        return view('frontend.cart.index');
    }

    public function add(Request $request, $id)
    {
        // TODO: Thêm sách vào giỏ hàng (kiểm tra SoLuong tồn kho)
        // TODO: Redirect lại trang cũ kèm thông báo thành công
    }

    public function update(Request $request) 
    {
        // Lấy ID từ input name="id"
        $id = $request->id; 
        $quantity = $request->quantity;
        
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove($id)
    {
        // TODO: Xóa một item khỏi giỏ hàng
    }

    public function clear()
    {
        // 1. TODO: Sử dụng session()->forget('cart') hoặc Session::flush()
        session()->forget('cart');

        // 2. TODO: Chuyển hướng người dùng về trang giỏ hàng kèm flash message
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}