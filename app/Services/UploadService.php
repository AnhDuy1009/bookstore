<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * Upload ảnh và trả về đường dẫn để lưu vào Database
     */
    public function uploadImage($file, $folder = 'books')
    {
        // TODO: Kiểm tra xem $file có hợp lệ không (isValid)
        // TODO: Tạo tên file duy nhất: time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        // TODO: Sử dụng Storage::disk('public')->putFileAs($folder, $file, $fileName);
        // TODO: Trả về đường dẫn: 'storage/' . $folder . '/' . $fileName
        
        // Gợi ý: Nếu nhóm muốn chuyên nghiệp hơn, hãy cài thư viện 'intervention/image' để resize ảnh tại đây.
    }

    /**
     * Xóa ảnh cũ khi cập nhật ảnh mới hoặc xóa dữ liệu
     */
    public function deleteOldImage($path)
    {
        // TODO: Kiểm tra $path có tồn tại không
        // TODO: Chuyển đổi đường dẫn từ URL sang đường dẫn vật lý trong folder storage
        // TODO: Nếu tồn tại, dùng Storage::disk('public')->delete($relativePath) để xóa
    }
}