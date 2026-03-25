<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // TODO: Kiểm tra nếu người dùng CHƯA đăng nhập (Auth::check() trả về false)
        // TODO: Nếu chưa đăng nhập, dùng return redirect()->route('login')->with('error', '...');
        
        // Nếu đã đăng nhập, cho phép đi tiếp vào Controller
        return $next($request);
    }
}