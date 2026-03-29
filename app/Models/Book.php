<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'sach';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'TenSach', 'GiaBan', 'SoLuongTon', 'MoTa', 'IDTacGia', 'IDDanhMuc', 'NhaXuatBan', 'NamXuatBan', 'SoTrang', 'Link_Anh_Bia'
    ];

    // Lấy thông tin tác giả
    public function tacGia() {
        return $this->belongsTo(Author::class, 'IDTacGia', 'ID');
    }

    // Lấy thông tin thể loại
    public function danhMuc() {
        return $this->belongsTo(Category::class, 'IDDanhMuc', 'ID');
    }

    // Lấy danh sách đánh giá của sách này
    public function reviews() {
        return $this->hasMany(Review::class, 'IDSach', 'ID');
    }

    // Lấy các chi tiết đơn hàng có chứa sách này
    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'IDSach', 'ID');
        
    }
}