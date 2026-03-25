@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>CHI TIẾT NGƯỜI DÙNG</h1>
        <p class="welcome">Thông tin chi tiết của user #{{ $user->ID }}</p>
    </div>

    <div class="admin-content">
        <div class="toolbar">
            <div class="action-buttons">
                <a class="btn btn-outline" href="{{ route('users.index') }}">← Quay lại</a>
                <a class="btn btn-primary" href="{{ route('users.edit', $user->ID) }}">Chỉnh sửa</a>
            </div>
        </div>

        <div class="card card-pad">
            <div style="display:grid; grid-template-columns: 1fr 2fr; gap:14px 20px;">
                <div class="info-label" style="font-weight:800;">Họ tên:</div>
                <div>{{ $user->HoTen }}</div>

                <div class="info-label" style="font-weight:800;">Email:</div>
                <div style="font-family:monospace;">{{ $user->Email }}</div>

                <div class="info-label" style="font-weight:800;">Số điện thoại:</div>
                <div>{{ $user->SoDienThoai ?? '-' }}</div>

                <div class="info-label" style="font-weight:800;">Trạng thái:</div>
                <div>
                    <span class="badge {{ $user->TrangThai == 'active' ? 'badge-green' : 'badge-red' }}">
                        {{ strtoupper($user->TrangThai) }}
                    </span>
                </div>

                <div class="info-label" style="font-weight:800;">Địa chỉ:</div>
                <div>{{ $user->DiaChi ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection