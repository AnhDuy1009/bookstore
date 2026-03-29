<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'danh_gia';
    protected $primaryKey = 'ID';
    
    // BƯỚC QUAN TRỌNG: Đổi true thành false vì bảng của bạn không có 2 cột created_at, updated_at
    public $timestamps = false; 

    // CẤP PHÉP CHÈN DỮ LIỆU ĐẦY ĐỦ CÁC CỘT TRONG DATABASE
    protected $fillable = [
        'IDNguoiDung',  
        'IDSach',
        'IDDonHang',   // Bắt buộc phải có thằng này
        'NoiDung',      
        'DiemDanhGia',
        'HinhAnh',     // Thêm vào cho đủ bộ
        'NgayDanhGia', 
        'TrangThai'    // Thêm vào để lưu trạng thái 'active'
    ];

    // Quan hệ với User
    public function user() {
        return $this->belongsTo(User::class, 'IDNguoiDung', 'ID');
    }

    // Quan hệ với Book
    public function book() {
        return $this->belongsTo(Book::class, 'IDSach', 'ID');
    }
}