<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'don_hang';
    protected $primaryKey = 'ID';
    
  
    public $timestamps = false; 

    protected $fillable = [
        'MaDonHang',
        'IDNguoiDung', 
        'NgayDat', 
        'TongTien', 
        'TrangThai', 
        'DiaChiGiaoHang', 
        'SoDienThoai',
        'PhuongThucThanhToan' 
    ];

    protected $casts = [
        'NgayDat' => 'datetime',
        'TongTien' => 'decimal:2',
    ];

    /**
     * Lấy thông tin người mua hàng
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'IDNguoiDung', 'ID');
    }

    /**
     * Lấy danh sách chi tiết các quyển sách trong đơn hàng
     */
    public function items(): HasMany
    {
        // Giả sử model chi tiết là OrderItem
        return $this->hasMany(OrderItem::class, 'IDDonHang', 'ID');
    }
    // Thêm vào file Order.php
    public function details()
    {
    // Liên kết 1 đơn hàng có nhiều chi tiết đơn hàng
        return $this->hasMany(OrderItem::class, 'IDDonHang', 'ID');
    }
}