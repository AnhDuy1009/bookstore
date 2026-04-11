<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Models\Order;

class OrderController extends Controller {
    protected $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function checkout(Request $request) {
        $cart = session()->get('cart');
        // Gọi Service để xử lý
        $order = $this->orderService->placeOrder($request->all(), $cart);
        
        session()->forget('cart'); // Xóa giỏ hàng sau khi đặt
        return redirect()->route('orders.history')->with('success', 'Đặt hàng thành công!');
    }

    public function history() {
        $orders = Order::where('IDNguoiDung', auth()->id())->latest()->get();
        return view('orders.history', compact('orders'));
    }
    public function store(Request $request) {
    // 1. Kiểm tra giỏ hàng (Hương làm phần này, bạn chỉ cần gọi session)
    $cart = session()->get('cart', []);
    if(empty($cart)) return back()->with('error', 'Giỏ hàng của bạn đang trống!');

    // 2. Tính tổng tiền (có trừ voucher nếu có)
    $total = 0;
    foreach($cart as $item) { $total += $item['price'] * $item['quantity']; }
    if(session()->has('voucher')) {
        $total = $total - ($total * session('voucher')['discount'] / 100);
    }

    // Tạo mảng dữ liệu chuẩn để truyền sang Service
        $checkoutData = [
            'MaDonHang'      => 'DH' . time(),
            'total'          => $total,
            'payment_method' => $request->PhuongThucThanhToan ?? 'cod',
            'address'        => $request->DiaChi, 
            'phone'          => $request->SDT
        ];

        // Gọi hàm tạo đơn hàng với đúng thứ tự biến
        
        $order = $this->orderService->createOrder(auth()->id(), $checkoutData, session('cart'));
    session()->forget(['cart', 'voucher']);
    return redirect()->route('orders.history')->with('success', 'Đặt hàng thành công!');
    }
}