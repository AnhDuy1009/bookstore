@extends('layouts.app') {{-- Hoặc layouts.auth tùy theo tên file layout tổng của bạn --}}

@section('title', 'Đăng nhập - Hiên Sách')

@section('content')
<div class="container auth-page auth-layout-page">
    <div class="auth-card auth-layout-card">
        <div class="auth-card-header">
            <h2 class="auth-panel-title">Chào mừng trở lại</h2>
            <p class="auth-panel-subtitle">Vui lòng đăng nhập để tiếp tục mua sắm</p>
        </div>

        @if(session('error'))
            <div class="auth-error auth-error-panel">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="auth-form auth-form-panel">
            @csrf
            
            <div class="form-group">
                <label>Email</label>
                <div class="input-icon-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control form-control-icon" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="input-icon-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control form-control-icon" placeholder="••••••" required>
                </div>
            </div>

            <div class="form-group auth-group-large">
                <label>Bạn là?</label>
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
                Đăng nhập
            </button>
        </form>

        <div class="auth-footer auth-panel-footer">
            <div>
                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            </div>
            <div class="auth-footer-register">
                Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection