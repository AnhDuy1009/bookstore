<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Tạo đơn hàng mới từ giỏ hàng 
     */
    public function createOrder($userId, array $checkoutData, array $cartItems)
    {
        return DB::transaction(function () use ($userId, $checkoutData, $cartItems) {
            try {
                // 1. Lưu vào bảng 'don_hang'
                $order = Order::create([
                    'MaDonHang' => $checkoutData['MaDonHang'],
                    'IDNguoiDung' => $userId,
                    'NgayDat' => now(),
                    'TongTien' => $checkoutData['total'],
                    'TrangThai' => 'Đang xử lý',
                    'DiaChiGiaoHang' => $checkoutData['address'],
                    'SoDienThoai' => $checkoutData['phone'],
                    'PhuongThucThanhToan' => $checkoutData['payment_method']
                ]);

                // 2. Duyệt qua $cartItems để lưu chi tiết

                foreach ($cartItems as $key => $item) {
            
                $bookId = is_numeric($key) ? $key : ($item['id'] ?? $item['ID'] ?? null);

                if ($bookId) {
                    \App\Models\OrderItem::create([
                        'IDDonHang' => $order->ID, // Đảm bảo ID này viết hoa khớp DB
                        'IDSach'    => $bookId,
                        'SoLuong'   => $item['quantity'] ?? 1,
                        'GiaBan'    => $item['price'] ?? 0
                    ]);

                    // 3. Trừ tồn kho
                    \Illuminate\Support\Facades\DB::table('sach')
                        ->where('ID', $bookId)
                        ->decrement('SoLuongTon', $item['quantity'] ?? 1);
                }
            }

                return $order;
            } catch (\Exception $e) {
                throw $e;
            }
        });
    }

    /**
     */
    public function placeOrder($data, $cart) {
        return DB::transaction(function () use ($data, $cart) {
            $order = Order::create([
                'IDNguoiDung' => auth()->id(),
                'TongTien' => $data['total'],
                'PhuongThucThanhToan' => $data['payment_method'],
                'TrangThai' => 'Đang xử lý',
                'GhiChu' => $data['note'] ?? ''
            ]);

            foreach ($cart as $idSach => $details) {
                OrderItem::create([
                    'IDDonHang' => $order->id,
                    'IDSach' => $idSach,
                    'SoLuong' => $details['quantity'],
                    'GiaBan' => $details['price']
                ]);
            }
            return $order;
        });
    }
}