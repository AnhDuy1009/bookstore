<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartApiController extends Controller
{
    protected $cartService;

    // Khởi tạo CartService
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // API lấy số lượng item trong giỏ hàng
    public function getCount()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'];
        }

        return response()->json([
            'count' => $total
        ]);
    }

    // API cập nhật số lượng sản phẩm khi bấm +/- 
    public function updateQuantity(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        // Tính lại tổng tiền
        $price = 0;

        foreach ($cart as $item) {
            $price += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'status' => 'success',
            'new_total' => $price
        ]);
    }
}