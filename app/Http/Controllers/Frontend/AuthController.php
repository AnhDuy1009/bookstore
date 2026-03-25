<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin() { return view('frontend.auth.login'); }

    public function login(Request $request) {
    // 1. Validate đầu vào cơ bản
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password'); 
        $role = $request->input('role');

        $user = User::where('Email', $email)->first();

    if ($user && $user->MatKhau === $password) {
        
        
        // Kiểm tra vai trò
        if ($user->VaiTro !== $role) {
            Auth::logout();
            return back()->with('error', 'Sai vai trò truy cập!');
        }
        Auth::login($user);
        $request->session()->regenerate();

        if ($user->VaiTro === 'admin') {
            return redirect()->route('admin.dashboard'); // Đảm bảo route này tồn tại
        }
        return redirect()->intended('/');
    }

    return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function showRegister() { return view('frontend.auth.register'); }

    public function register(Request $request) {
    // ... validate ...

            User::create([
                'HoTen' => $request->name,
                'Email' => $request->email,
                'MatKhau' =>$request->password, 
                'VaiTro' => 'user',
                'TrangThai' => 'active'
            ]);
            
            return redirect()->route('login')->with('success', 'Đăng ký thành công!');
        }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('success', 'Hẹn gặp lại bạn lần sau!');
    }

    public function showForgotPassword() {
    // Trỏ vào file: resources/views/frontend/passwords/email.blade.php
    return view('frontend.passwords.email');
    }

    public function showResetPassword($token) {
        // Trỏ vào file: resources/views/frontend/passwords/reset.blade.php
        return view('frontend.passwords.reset', ['token' => $token]);
    }
}