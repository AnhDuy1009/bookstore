<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'gio_hang';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'IDNguoiDung',
        'IDSach',
        'SoLuong'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'IDNguoiDung');
    }

    public function items(){
        return $this->hasMany(CartItem::class, 'IDGioHang');
    }
}