<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'don_hang';
    protected $primaryKey = 'ID';
    
    // Tắt timestamps vì DB cũ có thể chỉ có cột NgayDat thay vì created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'IDNguoiDung', 
        'NgayDat', 
        'TongTien', 
        'TrangThai', 
        'DiaChiGiaoHang', 
        'SoDienThoai',
        'PhuongThucThanhToan' // Nên thêm cột này nếu bạn có dùng Momo/VNPAY/COD
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
}