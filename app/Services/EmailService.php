<?php

namespace App\Services;

use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Gửi email xác nhận đơn hàng kèm chi tiết sản phẩm
     */
    public function sendOrderConfirmation(Order $order)
    {
        $order->loadMissing(['user', 'items.book']);

        $email = $order->user?->Email;
        if (empty($email)) {
            Log::warning('Không thể gửi email xác nhận đơn hàng do thiếu email khách hàng.', [
                'order_id' => $order->ID,
            ]);
            return;
        }

        Mail::to($email)->send(new OrderConfirmed($order));
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