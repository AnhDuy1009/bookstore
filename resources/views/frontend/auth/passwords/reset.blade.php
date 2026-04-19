@extends('layouts.auth')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<h2 class="auth-heading">Mật khẩu mới</h2>

<form action="{{ route('password.update') }}" method="POST" class="auth-form">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" readonly>
    </div>

    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
        @error('password')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group auth-group-large">
        <label>Xác nhận mật khẩu mới</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn-submit btn-success">
        Cập nhật mật khẩu
    </button>
</form>
@endsection