@extends('layouts.app') {{-- Hoặc layouts.auth tùy theo tên file layout tổng của bạn --}}

@section('title', 'Đăng nhập - Hiên Sách')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 40px 0;">
        <div style="width: 100%; max-width: 450px; background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-top: 5px solid #3498db;">
            
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-family: 'Playfair Display', serif; color: #2c3e50; font-size: 28px; margin-bottom: 10px;">Chào mừng trở lại</h2>
                <p style="color: #7f8c8d; font-size: 14px;">Vui lòng đăng nhập để tiếp tục mua sắm</p>
            </div>

            @if(session('error'))
                <div style="background-color: #fff5f5; color: #e74c3c; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #e74c3c;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 8px;">Email</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #bdc3c7;"></i>
                        <input type="email" name="email" 
                               style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #ddd; border-radius: 25px; outline: none; transition: 0.3s;" 
                               placeholder="example@gmail.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <small style="color: #e74c3c; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 8px;">Mật khẩu</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #bdc3c7;"></i>
                        <input type="password" name="password" 
                               style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #ddd; border-radius: 25px; outline: none;" 
                               placeholder="••••••" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">Bạn là?</label>
                    <div style="display: flex; gap: 20px;">
                        <label style="cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="role" value="user" checked style="accent-color: #3498db;"> Khách hàng
                        </label>
                        <label style="cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="role" value="admin" style="accent-color: #3498db;"> Quản trị viên
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login" style="width: 100%; padding: 12px; border: none; font-size: 16px; font-weight: 600; cursor: pointer;">
                    Đăng nhập
                </button>
            </form>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <div style="margin-bottom: 10px;">
                    <a href="{{ route('password.request') }}" style="color: #7f8c8d; text-decoration: none; font-size: 14px; transition: 0.3s;">
                        Quên mật khẩu?
                    </a>
                </div>
                <div style="font-size: 14px; color: #2c3e50;">
                    Chưa có tài khoản? 
                    <a href="{{ route('register') }}" style="color: #3498db; text-decoration: none; font-weight: 700;">
                        Đăng ký ngay
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection