<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'danh_gia';
    protected $primaryKey = 'ID';
    public $timestamps = true; // Thường đánh giá sẽ cần created_at

    protected $fillable = ['IDNguoiDung', 'IDSach', 'NoiDung', 'DiemDanhGia'];

    public function user() {
        return $this->belongsTo(User::class, 'IDNguoiDung', 'ID');
    }

    public function book() {
        return $this->belongsTo(Book::class, 'IDSach', 'ID');
    }
}