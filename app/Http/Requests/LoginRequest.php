<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Email' => 'required|email',
            'MatKhau' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'Email.required' => 'Vui lòng nhập Email để đăng nhập.',
            'Email.email' => 'Email không đúng định dạng.',
            'MatKhau.required' => 'Vui lòng nhập mật khẩu.',
        ];
    }
}