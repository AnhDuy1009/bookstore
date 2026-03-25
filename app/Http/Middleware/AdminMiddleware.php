<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập (Auth) chưa
        if (Auth::check()) {
            $user = Auth::user();

            // 2. Kiểm tra cột 'VaiTro' trong DB có phải là 'admin' không
            // Lưu ý: 'admin' phải viết thường y hệt như trong Database bạn gõ
            if ($user->VaiTro === 'admin') {
                return $next($request); // Cho phép đi tiếp vào trang Admin
            }
        }

        // 3. Nếu không phải Admin hoặc chưa đăng nhập, đá về trang chủ kèm thông báo
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào khu vực Quản trị viên!');
    }
}