<?php

namespace App\Services;

class PaymentService
{
    /**
     * Tạo URL thanh toán VNPay
     */
    public function createVnPayUrl($order)
    {
        // TODO: Cấu hình các tham số vnp_TmnCode, vnp_HashSecret từ file .env
        // TODO: Xây dựng mảng dữ liệu vnp_Params (Số tiền, Mã đơn hàng, URL phản hồi)
        // TODO: Trả về chuỗi URL để Redirect khách hàng sang trang VNPay
    }

    /**
     * Xử lý kết quả trả về từ cổng thanh toán (IPN/Return)
     */
    public function handleCallback($request)
    {
        // TODO: Kiểm tra chữ ký (Checksum) để đảm bảo dữ liệu không bị sửa đổi
        // TODO: Nếu thành công, cập nhật 'TrangThai' đơn hàng thành 'DaThanhToan'
        // TODO: Nếu thất bại, cập nhật 'TrangThai' thành 'ThanhToanThatBai'
    }
}