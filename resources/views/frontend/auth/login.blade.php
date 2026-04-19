@extends('layouts.auth')

@section('title', 'Đăng nhập')

@section('content')
<div class="container auth-page auth-login-page">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-logo">
                <a href="/">
                    <i class="fas fa-book"></i>
                    <span>HIÊN SÁCH</span>
                </a>
            </div>
            <h2 class="auth-panel-title">Chào mừng trở lại!</h2>
        </div>

        @if(session('error'))
            <div class="auth-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required placeholder="example@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required placeholder="******">
            </div>

            <div class="form-group auth-group-large">
                <label>Vai trò truy cập</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="role" value="user" checked> Khách hàng
                    </label>
                    <label>
                        <input type="radio" name="role" value="admin"> Quản trị viên
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-login auth-submit-button">
                Đăng nhập ngay
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            <span class="footer-divider">|</span>
            <a href="{{ route('register') }}">Đăng ký tài khoản mới</a>
        </div>
    </div>
</div>
@endsection