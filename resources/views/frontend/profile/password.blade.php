@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-4"><i class="fas fa-key me-2 text-warning"></i>Đổi mật khẩu</h4>

                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Xác nhận mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control rounded-3" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">CẬP NHẬT MẬT KHẨU</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection