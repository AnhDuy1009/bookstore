@extends('layouts.auth')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<h2 style="text-align: center; color: #2c3e50;">Mật khẩu mới</h2>

<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group" style="margin-bottom: 15px;">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" readonly>
    </div>

    <div class="form-group" style="margin-bottom: 15px;">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
        @error('password')
            <small style="color: red;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label>Xác nhận mật khẩu mới</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn-submit" style="background-color: #27ae60; color: white; width: 100%; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
        Cập nhật mật khẩu
    </button>
</form>
@endsection