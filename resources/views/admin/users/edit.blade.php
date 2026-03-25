@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>SỬA NGƯỜI DÙNG</h1>
        <p class="welcome">Cập nhật thông tin user #{{ $user->ID }}</p>
    </div>

    <div class="admin-content">
        <div class="toolbar">
            <div class="action-buttons">
                <a class="btn btn-outline" href="{{ route('users.index') }}">Hủy</a>
            </div>
        </div>

        <div class="form-card">
            <form action="{{ route('users.update', $user->ID) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input name="HoTen" value="{{ old('HoTen', $user->HoTen) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input name="Email" value="{{ old('Email', $user->Email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>SĐT</label>
                        <input name="SoDienThoai" value="{{ old('SoDienThoai', $user->SoDienThoai) }}">
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="TrangThai">
                            <option value="active" {{ $user->TrangThai == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ $user->TrangThai == 'inactive' ? 'selected' : '' }}>Khóa</option>
                        </select>
                    </div>

                    <div class="form-group form-span-2">
                        <label>Địa chỉ</label>
                        <input name="DiaChi" value="{{ old('DiaChi', $user->DiaChi) }}">
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection