<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Cập nhật thông tin cá nhân
     * TODO: Trả về true nếu ID của User đang đăng nhập bằng đúng ID của User đang định sửa
     */
    public function update(User $currentUser, User $targetUser)
    {
        return $currentUser->ID === $targetUser->ID;
    }

    /**
     * Quản lý người dùng (Dành cho Admin)
     * TODO: Chỉ Admin mới được quyền khóa/mở khóa tài khoản người khác
     */
    public function manage(User $user)
    {
        return $user->VaiTro === 'admin';
    }
}