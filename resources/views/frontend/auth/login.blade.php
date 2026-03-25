@extends('layouts.auth')

@section('title', 'Đăng nhập')

@section('content')
<div class="container" style="margin: 50px auto; max-width: 450px;">
    <div style="background: #ffffff; padding: 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 5px solid #3498db;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="logo" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
                <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-book" style="font-size: 28px; color: #3498db;"></i> 
                    <span style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; background: linear-gradient(90deg, #3498db, #2c3e50); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        HIÊN SÁCH
                    </span>
                </a>
            </div>
            <h2 style="font-family: 'Playfair Display', serif; color: #2c3e50; font-size: 24px;">Chào mừng trở lại!</h2>
        </div>

        @if(session('error'))
            <div style="background-color: #fdf2f2; color: #e74c3c; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: 600; color: #2c3e50; display: block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" class="form-control" 
                       style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                       required placeholder="example@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <small style="color: #e74c3c; display: block; margin-top: 5px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="font-weight: 600; color: #2c3e50; display: block; margin-bottom: 5px;">Mật khẩu</label>
                <input type="password" name="password" class="form-control" 
                       style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                       required placeholder="******">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label style="font-weight: 600; color: #2c3e50; display: block; margin-bottom: 8px;">Vai trò truy cập</label>
                <div style="display: flex; gap: 20px;">
                    <label style="font-weight: 500; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <input type="radio" name="role" value="user" checked style="accent-color: #3498db;"> Khách hàng
                    </label>
                    <label style="font-weight: 500; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <input type="radio" name="role" value="admin" style="accent-color: #3498db;"> Quản trị viên
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-login" style="width: 100%; border: none; padding: 12px; font-size: 16px; font-weight: 600;">
                Đăng nhập ngay
            </button>
        </form>

        <div class="auth-footer" style="text-align: center; margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="{{ route('password.request') }}" style="color: #7f8c8d; text-decoration: none; font-size: 13px; transition: 0.3s;">
                Quên mật khẩu?
            </a>
            <span style="margin: 0 10px; color: #eee;">|</span>
            <a href="{{ route('register') }}" style="color: #3498db; text-decoration: none; font-weight: 700; font-size: 14px;">
                Đăng ký tài khoản mới
            </a>
        </div>
    </div>
</div>
@endsection