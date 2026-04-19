@extends('layouts.auth')

@section('title', 'Quên mật khẩu')

@section('content')
<h2 class="auth-heading">Khôi phục mật khẩu</h2>
<p class="auth-description">
    Nhập email của bạn để nhận liên kết đặt lại mật khẩu mới.
</p>

@if (session('status'))
    <div class="auth-status">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.email') }}" method="POST" class="auth-form">
    @csrf
    <div class="form-group">
        <label>Địa chỉ Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@example.com">
        @error('email')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-submit btn-primary">
        Gửi yêu cầu
    </button>
</form>

<div class="auth-link-row">
    <a href="{{ route('login') }}" class="auth-link">
        <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
    </a>
</div>
@endsection