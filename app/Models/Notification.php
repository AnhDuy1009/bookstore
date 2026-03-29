<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'thong_bao';
    protected $primaryKey = 'ID';
    public $timestamps = false; // Vì mình dùng NgayTao làm thủ công

    protected $fillable = [
        'IDNguoiDung',
        'TieuDe',
        'NoiDung',
        'DaDoc',
        'NgayTao'
    ];

    // Liên kết với User
    public function user() {
        return $this->belongsTo(User::class, 'IDNguoiDung', 'ID');
    }
}