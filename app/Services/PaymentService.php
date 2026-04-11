<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class PaymentService
{
    /**
     * Tạo URL thanh toán VNPay
     */
    public function createVnPayUrl($order)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL');
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $vnp_TxnRef = $order->ID; // Mã đơn hàng trong DB của bạn
        $vnp_OrderInfo = "Thanh toan don hang #" . $order->ID;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->TongTien * 100; // VNPay tính theo đơn vị Đồng * 100
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB'; // Ngân hàng test mặc định
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * Xử lý kết quả trả về từ cổng thanh toán
     */
    public function handleCallback($request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                return ['status' => 'success', 'order_id' => $request->vnp_TxnRef];
            }
        }
        
        return ['status' => 'fail', 'order_id' => $request->vnp_TxnRef];
    }

    /**
     * Tạo URL thanh toán MoMo (Giả lập)
     */
    public function createMoMoUrl($order)
    {
        // Đây là bản giả lập đơn giản cho đồ án
        // Trong thực tế sẽ cần endpoint và secret key của MoMo
        return "https://test-payment.momo.vn/pay/gate?amount=" . $order->TongTien . "&orderId=" . $order->ID;
    }

    /**
     * Xử lý thanh toán COD (Thanh toán khi nhận hàng)
     */
    public function handleCOD($order)
    {
        // Với COD, chúng ta chỉ cần xác nhận đơn hàng đã được tạo thành công
        // Trạng thái đơn hàng vẫn là 'Đang xử lý' cho đến khi khách nhận hàng
        return true;
    }

}