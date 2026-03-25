@extends('layouts.auth')

@section('title', 'Quên mật khẩu')

@section('content')
<h2 style="text-align: center; color: #2c3e50;">Khôi phục mật khẩu</h2>
<p style="text-align: center; font-size: 0.9rem; color: #7f8c8d; margin-bottom: 20px;">
    Nhập email của bạn để nhận liên kết đặt lại mật khẩu mới.
</p>

@if (session('status'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Địa chỉ Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@example.com">
        @error('email')
            <small style="color: red; display: block; margin-top: 5px;">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-submit" style="background-color: #3498db; color: white; width: 100%; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
        Gửi yêu cầu
    </button>
</form>

<div style="margin-top: 20px; text-align: center;">
    <a href="{{ route('login') }}" style="text-decoration: none; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
    </a>
</div>
@endsection