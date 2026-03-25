<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['HoTen', 'Email', 'MatKhau', 'SoDienThoai', 'DiaChi', 'VaiTro'];

    protected $hidden = ['MatKhau'];



    // Một user có nhiều đơn hàng
    public function orders() {
        return $this->hasMany(Order::class, 'IDNguoiDung', 'ID');
    }

    // Một user có nhiều đánh giá (Nếu bạn tạo bảng danh_gia)
    public function reviews() {
        return $this->hasMany(Review::class, 'IDNguoiDung', 'ID');
    }
    
    // Nếu bạn lưu giỏ hàng vào Database
    public function carts() {
        return $this->hasMany(Cart::class, 'IDNguoiDung', 'ID');
    }
}