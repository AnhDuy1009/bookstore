<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            // TODO: Validate 'Email' phải đúng định dạng email, bắt buộc
            // TODO: Nếu là Đăng ký (Register), 'Email' phải là unique trong bảng 'nguoi_dung'
            // TODO: Validate 'MatKhau' tối thiểu 6 ký tự
            // TODO: Nếu là Đăng ký, 'MatKhau' phải có thêm rule 'confirmed' (nhập lại mật khẩu)
        ];
    }
}