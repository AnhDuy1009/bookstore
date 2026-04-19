@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - Hiên Sách')

@section('content')
<div class="container auth-page auth-register-page">
    <div class="auth-card auth-card-centered">
        <div class="auth-card-header">
            <div class="auth-logo">
                <a href="/">
                    <i class="fas fa-book"></i>
                    <span>HIÊN SÁCH</span>
                </a>
            </div>
            <h2 class="auth-panel-title">Tạo tài khoản mới</h2>
            <p class="auth-panel-subtitle">Gia nhập cộng đồng yêu sách ngay hôm nay</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="HoTen" class="form-control" placeholder="Nguyễn Văn A" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="MatKhau" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group auth-group-large">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="MatKhau_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-register auth-submit-button">
                Đăng ký tài khoản
            </button>
        </form>

        <div class="auth-footer">
            <p>
                Đã có tài khoản? 
                <a href="{{ route('login') }}">Đăng nhập tại đây</a>
            </p>
        </div>
    </div>
</div>
@endsection