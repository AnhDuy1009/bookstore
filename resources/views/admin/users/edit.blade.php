@extends('layouts.admin')

@section('title', 'Sửa người dùng #' . $user->ID)

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-user-edit"></i> CHỈNH SỬA NGƯỜI DÙNG</h4>
            <p class="text-muted small mb-0">Cập nhật thông tin tài khoản user #{{ $user->ID }}</p>
        </div>
        <div class="text-end">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.users.index') }}">
                <i class="fas fa-times"></i> Hủy bỏ
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->ID) }}" method="POST">
        @csrf 
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-user me-1"></i> Họ tên khách hàng</label>
                    <input type="text" name="HoTen" class="form-control form-control-lg" 
                           value="{{ old('HoTen', $user->HoTen) }}" required placeholder="Nhập đầy đủ họ tên">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-envelope me-1"></i> Địa chỉ Email</label>
                    <input type="email" name="Email" class="form-control" 
                           value="{{ old('Email', $user->Email) }}" required placeholder="example@gmail.com">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-phone me-1"></i> Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control" 
                           value="{{ old('SoDienThoai', $user->SoDienThoai) }}" placeholder="Ví dụ: 0912xxxxxx">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-toggle-on me-1"></i> Trạng thái tài khoản</label>
                    <select name="TrangThai" class="form-select">
                        <option value="active" {{ $user->TrangThai == 'active' ? 'selected' : '' }}>🟢 Hoạt động (Bình thường)</option>
                        <option value="inactive" {{ $user->TrangThai == 'inactive' ? 'selected' : '' }}>🔴 Khóa (Ngừng hoạt động)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-user-tag me-1"></i> Vai trò người dùng</label>
                    <select name="Role" class="form-select">
                        {{-- Kiểm tra giá trị cũ để hiển thị đúng option --}}
                        <option value="user" {{ (old('Role', $user->Role) == 'user' || old('Role', $user->MaVaiTro) != 1) ? 'selected' : '' }}>
                            👤 Khách hàng
                        </option>
                        <option value="admin" {{ (old('Role', $user->Role) == 'admin' || old('Role', $user->MaVaiTro) == 1) ? 'selected' : '' }}>
                            🛡️ Quản trị viên (Admin)
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Địa chỉ thường trú</label>
                    <input type="text" name="DiaChi" class="form-control" 
                           value="{{ old('DiaChi', $user->DiaChi) }}" placeholder="Nhập địa chỉ nhận hàng của người dùng">
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-5 btn-lg">
                <i class="fas fa-save me-2"></i> Lưu thay đổi
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 ms-2">Quay lại danh sách</a>
        </div>
    </form>

    <div class="text-center text-muted mt-5 pt-3 border-top small">
        © {{ date('Y') }} Hiên Sách - Quản lý người dùng hệ thống
    </div>
</div>
@endsection