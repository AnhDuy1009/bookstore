<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        // Thường giống StoreBookRequest nhưng 'AnhBia' có thể để trống (nullable)
        return [
            // TODO: Validate 'TenSach', 'GiaBan', 'SoLuong', 'IDTacGia', 'IDTheLoai'
            // TODO: 'AnhBia' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}