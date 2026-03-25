<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;

class BookPolicy
{
    /**
     * Ai có quyền xem danh sách và thêm sách?
     * TODO: Trả về true nếu User có VaiTro là 'admin'
     */
    public function create(User $user)
    {
        return $user->VaiTro === 'admin';
    }

    /**
     * Ai có quyền sửa/xóa sách?
     * TODO: Chỉ Admin mới có quyền thực hiện hành động này
     */
    public function update(User $user, Book $book)
    {
        return $user->VaiTro === 'admin';
    }

    public function delete(User $user, Book $book)
    {
        return $user->VaiTro === 'admin';
    }
}