<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            // TODO: Validate 'DiaChiGiaoHang' là bắt buộc
            // TODO: Validate 'SoDienThoai' là số, đúng định dạng số điện thoại VN (10 số)
            // TODO: Validate 'GhiChu' (nếu có) giới hạn ký tự
        ];
    }

    public function messages()
    {
        return [
            'DiaChiGiaoHang.required' => 'Vui lòng nhập địa chỉ để chúng tôi giao hàng.',
            'SoDienThoai.required' => 'Số điện thoại là bắt buộc để liên hệ giao hàng.',
        ];
    }
}