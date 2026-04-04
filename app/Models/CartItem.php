<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'gio_hang_chi_tiet'; // tên bảng chi tiết giỏ hàng
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'IDGioHang', // ID của giỏ hàng
        'IDSach',    // ID sách
        'SoLuong'    // Số lượng
    ];

    // Mỗi item thuộc về 1 Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'IDGioHang');
    }

    // Mỗi item liên quan tới 1 Book
    public function book()
    {
        return $this->belongsTo(Book::class, 'IDSach');
    }
}