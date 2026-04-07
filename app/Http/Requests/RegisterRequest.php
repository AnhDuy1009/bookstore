<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Sử dụng tên cột 'HoTen' từ database
            'HoTen' => 'required|string|max:255', 
            // Kiểm tra Email duy nhất trong bảng 'nguoi_dung'
            'Email' => 'required|email|unique:nguoi_dung,Email', 
            // Mật khẩu tối thiểu 8 ký tự và phải có trường xác nhận (MatKhau_confirmation)
            'MatKhau' => 'required|string|min:8|confirmed', 
            // Các trường bổ sung có trong bảng 'nguoi_dung'
            'SoDienThoai' => 'nullable|numeric|digits_between:10,11',
            'DiaChi' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'HoTen.required' => 'Vui lòng nhập họ và tên.',
            'Email.required' => 'Email không được để trống.',
            'Email.email' => 'Định dạng email không hợp lệ.',
            'Email.unique' => 'Email này đã được đăng ký sử dụng.',
            'MatKhau.required' => 'Vui lòng nhập mật khẩu.',
            'MatKhau.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'MatKhau.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'SoDienThoai.numeric' => 'Số điện thoại chỉ được chứa chữ số.',
        ];
    }
}