<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // TODO: Lấy danh sách đơn hàng mới nhất (OrderBy NgayDat Desc)
        return view('admin.orders.index');
    }

    public function show($id)
    {
        // TODO: Lấy chi tiết đơn hàng (OrderItem) kèm thông tin Sách
        return view('admin.orders.show');
    }

    public function updateStatus(Request $request, $id)
    {
        // TODO: Cập nhật cột 'TrangThai' (Ví dụ: Đang giao, Đã giao, Đã hủy)
    }

    public function print($id)
    {
        // Lấy đơn hàng kèm chi tiết và thông tin sách để in
        $order = Order::with('details.book')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }
}