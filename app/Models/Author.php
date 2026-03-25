<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'tac_gia';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['TenTacGia', 'TieuSu', 'HinhAnh'];

    // Một tác giả có nhiều đầu sách
    public function books() {
        return $this->hasMany(Book::class, 'IDTacGia', 'ID');
    }
}