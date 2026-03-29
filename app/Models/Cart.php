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

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'IDNguoiDung');
    }

    // Quan hệ với Book
    public function book()
    {
        return $this->belongsTo(Book::class, 'IDSach');
    }
}