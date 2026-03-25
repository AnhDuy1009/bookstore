<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'danh_muc';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['TenDanhMuc'];

    // Một thể loại có nhiều sách
    public function books() {
        return $this->hasMany(Book::class, 'IDDanhMuc', 'ID');
    }
}