<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


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
    
            $request->validate([]);
            User::create([
                'HoTen' => $request->HoTen,
                'Email' => $request->Email,
                'MatKhau' =>$request->MatKhau, 
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
    // Trỏ vào file: resources/views/frontend/auth/passwords/email.blade.php
    return view('frontend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('Email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.'])->withInput();
        }

        $token = Str::random(64);
        Cache::put('password_reset_' . $token, $user->Email, now()->addMinutes(60));

        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $user->Email,
        ])->with('status', 'Vui lòng nhập mật khẩu mới.');
    }

    public function showResetPassword($token) {
        // Trỏ vào file: resources/views/frontend/auth/passwords/reset.blade.php
        $email = request('email');
        $cachedEmail = Cache::get('password_reset_' . $token);

        if (! $cachedEmail || ! $email || $cachedEmail !== $email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
        }

        return view('frontend.auth.passwords.reset', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $cachedEmail = Cache::get('password_reset_' . $request->token);

        if (! $cachedEmail || $cachedEmail !== $request->email) {
            return back()->withErrors(['email' => 'Token đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
        }

        $user = User::where('Email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản tương ứng.']);
        }

        // Hệ thống hiện tại đang đăng nhập bằng so sánh chuỗi thô ở cột MatKhau.
        $user->MatKhau = $request->password;
        $user->save();

        Cache::forget('password_reset_' . $request->token);

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}