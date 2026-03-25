<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\User;

class EmailService
{
    /**
     * Gửi email xác nhận đơn hàng kèm chi tiết sản phẩm
     */
    public function sendOrderConfirmation(Order $order)
    {
        // TODO: Lấy thông tin User từ $order->user (Email, HoTen)
        // TODO: Lấy danh sách sản phẩm từ $order->items (TenSach, SoLuong, GiaBan)
        // TODO: Tạo một Mailable class (php artisan make:mail OrderConfirmed)
        // TODO: Sử dụng Mail::to($email)->send(new OrderConfirmed($order));
        
        // Ghi chú: Nhắc thành viên cấu hình MAIL_HOST, MAIL_PORT trong file .env
    }

    /**
     * Gửi email hướng dẫn lấy lại mật khẩu
     */
    public function sendResetPasswordEmail(User $user)
    {
        // TODO: Tạo một Token bảo mật hoặc mã OTP
        // TODO: Gửi link reset password chứa token này vào Email của User
        // TODO: Mail::to($user->Email)->send(new ResetPasswordMail($user, $token));
    }
}