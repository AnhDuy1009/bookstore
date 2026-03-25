<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize() { return true; } // Cho phép qua cửa kiểm tra quyền cơ bản

    public function rules()
    {
        return [
            // TODO: Validate 'TenSach' là bắt buộc, không quá 255 ký tự
            // TODO: Validate 'GiaBan' là số, tối thiểu là 0
            // TODO: Validate 'SoLuong' là số nguyên, tối thiểu là 0
            // TODO: Validate 'IDTacGia' phải tồn tại trong bảng 'tac_gia' (cột ID)
            // TODO: Validate 'IDTheLoai' phải tồn tại trong bảng 'the_loai' (cột ID)
            // TODO: Validate 'AnhBia' phải là file ảnh (jpeg, png, jpg), tối đa 2MB
        ];
    }

    public function messages()
    {
        return [
            // TODO: Viết thông báo lỗi bằng tiếng Việt tương ứng cho các rules trên
            // Ví dụ: 'TenSach.required' => 'Tên sách không được để trống'
        ];
    }
}