<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Xem chi tiết đơn hàng
     * TODO: Trả về true nếu: 
     * 1. User đó là Admin (Admin xem đơn của ai cũng được)
     * 2. Hoặc cột 'IDNguoiDung' của đơn hàng trùng với 'ID' của User đang đăng nhập
     */
    public function view(User $user, Order $order)
    {
        return $user->VaiTro === 'admin' || $user->ID === $order->IDNguoiDung;
    }

    /**
     * Hủy đơn hàng
     * TODO: Chỉ cho phép hủy nếu đơn hàng đó thuộc về họ và TrangThai đang là 'ChoDuyet'
     */
    public function cancel(User $user, Order $order)
    {
        return $user->ID === $order->IDNguoiDung && $order->TrangThai === 'ChoDuyet';
    }
}