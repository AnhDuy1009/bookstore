@extends('layouts.auth')

@section('title', 'Đăng ký')

@section('content')
<div class="container auth-page auth-register-page">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-logo">
                <a href="/">
                    <i class="fas fa-book"></i>
                    <span>HIÊN SÁCH</span>
                </a>
            </div>
            <h2 class="auth-panel-title">Tạo tài khoản mới</h2>
        </div>

        @if($errors->any())
            <div class="auth-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="HoTen" class="form-control" required placeholder="Nguyễn Văn A" value="{{ old('HoTen') }}">
                @error('HoTen')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" class="form-control" required placeholder="example@gmail.com" value="{{ old('Email') }}">
                @error('Email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="MatKhau" class="form-control" required placeholder="******">
                @error('MatKhau')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group auth-group-large">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="MatKhau_confirmation" class="form-control" required placeholder="******">
            </div>

            <button type="submit" class="btn-login auth-submit-button">
                Đăng ký ngay
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập tại đây</a>
        </div>
    </div>
</div>
@endsection