<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Kiểm tra nếu người dùng CHƯA đăng nhập (Auth::check() trả về false)
        if (!Auth::check()) {
            // 2. Nếu chưa đăng nhập, chuyển hướng về route 'login' kèm thông báo lỗi
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để truy cập chức năng này!');
        }
        
        // Nếu đã đăng nhập, cho phép đi tiếp vào Controller
        return $next($request);
    }
}