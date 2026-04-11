@extends('layouts.admin')

@section('title', 'Thêm thành viên mới')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-user-plus"></i> THÊM THÀNH VIÊN MỚI</h4>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.users.index') }}">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                <input type="text" name="HoTen" class="form-control" required placeholder="Nguyễn Văn A">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="Email" class="form-control" required placeholder="email@example.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                <input type="password" name="MatKhau" class="form-control" required placeholder="Ít nhất 6 ký tự">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Vai trò</label>
                <select name="Role" class="form-select">
                    <option value="user">Khách hàng</option>
                    <option value="admin">Quản trị viên (Admin)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Số điện thoại</label>
                <input type="text" name="SoDienThoai" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Địa chỉ</label>
                <input type="text" name="DiaChi" class="form-control">
            </div>
        </div>

        <div class="mt-4 pt-3 border-top text-end">
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save me-2"></i> Xác nhận thêm mới
            </button>
        </div>
    </form>
</div>
@endsection