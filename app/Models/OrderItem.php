<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'chi_tiet_don_hang';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['IDDonHang', 'IDSach', 'SoLuong', 'GiaBan'];

    // Thuộc về một đơn hàng
    public function order() {
        return $this->belongsTo(Order::class, 'IDDonHang', 'ID');
    }

    // Link tới thông tin sách
    public function book() {
        return $this->belongsTo(Book::class, 'IDSach', 'ID');
    }
}