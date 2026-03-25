<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartApiController extends Controller
{
    // TODO: Viết API lấy số lượng item hiện tại để hiển thị trên icon Giỏ hàng (Navbar)
    public function getCount()
    {
        // TODO: Trả về JSON: ['count' => $total]
    }

    // TODO: Viết API cập nhật số lượng khi user bấm nút +/- trong trang giỏ hàng
    public function updateQuantity(Request $request)
    {
        // TODO: Nhận ID và SoLuong mới
        // TODO: Trả về JSON: ['status' => 'success', 'new_total' => $price]
    }
}