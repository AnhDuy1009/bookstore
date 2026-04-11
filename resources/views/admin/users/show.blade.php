@extends('layouts.admin')

@section('title', 'Chi tiết người dùng #' . $user->ID)

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-user-circle"></i> HỒ SƠ NGƯỜI DÙNG</h4>
            <p class="text-muted small mb-0">Thông tin tài khoản chi tiết của user #{{ $user->ID }}</p>
        </div>
        <div class="text-end">
            <a class="btn btn-outline-secondary btn-sm me-2" href="{{ route('admin.users.index') }}">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user->ID) }}">
                <i class="fas fa-edit"></i> Chỉnh sửa thông tin
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 text-center border-end">
            <div class="mb-3 mt-3">
                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center text-white shadow" style="width: 120px; height: 120px; font-size: 3rem;">
                    {{ strtoupper(substr($user->HoTen, 0, 1)) }}
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->HoTen }}</h5>
            <p class="text-muted small mb-3">{{ $user->Email }}</p>
            
            <div class="mb-4">
                @if($user->TrangThai == 'active' || $user->status == 'active')
                    <span class="badge bg-success px-4 py-2 fs-6"><i class="fas fa-check-circle me-1"></i> ĐANG HOẠT ĐỘNG</span>
                @else
                    <span class="badge bg-danger px-4 py-2 fs-6"><i class="fas fa-ban me-1"></i> ĐÃ BỊ KHÓA</span>
                @endif
            </div>
            
            <div class="p-3 bg-light rounded text-start">
                <div class="small text-muted mb-1">Ngày tham gia hệ thống:</div>
                <div class="fw-bold"><i class="far fa-calendar-alt me-1"></i> {{ date('d/m/Y H:i', strtotime($user->NgayTao ?? $user->created_at)) }}</div>
            </div>
        </div>

        <div class="col-md-8 ps-md-5">
            <h6 class="fw-bold text-dark mb-4 mt-3 border-bottom pb-2">THÔNG TIN CÁ NHÂN</h6>
            
            <div class="row g-4">
                <div class="col-sm-6">
                    <label class="text-muted small fw-bold d-block mb-1">HỌ VÀ TÊN</label>
                    <div class="text-dark fw-bold">{{ $user->HoTen }}</div>
                </div>

                <div class="col-sm-6">
                    <label class="text-muted small fw-bold d-block mb-1">ĐỊA CHỈ EMAIL</label>
                    <div class="text-dark fw-bold" style="font-family: monospace;">{{ $user->Email }}</div>
                </div>

                <div class="col-sm-6">
                    <label class="text-muted small fw-bold d-block mb-1">SỐ ĐIỆN THOẠI</label>
                    <div class="text-dark fw-bold">{{ $user->SoDienThoai ?? 'Chưa cập nhật' }}</div>
                </div>

                <div class="col-sm-6">
                    <label class="text-muted small fw-bold d-block mb-1">VAI TRÒ HỆ THỐNG</label>
                    <div class="text-dark fw-bold">
                        
                        @if(strtolower($user->VaiTro) == 'admin')
                            Quản trị viên (Admin)
                        @else
                            Khách hàng (Customer)
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted small fw-bold d-block mb-1">ĐỊA CHỈ GIAO HÀNG</label>
                    <div class="p-3 bg-light rounded border-start border-primary border-4">
                        {{ $user->DiaChi ?? 'Người dùng này chưa cung cấp địa chỉ cụ thể.' }}
                    </div>
                </div>
            </div>

            <div class="mt-5 p-3 rounded border border-warning bg-warning bg-opacity-10">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart fa-2x text-warning me-3"></i>
                    <div>
                        <div class="fw-bold text-dark">Lịch sử mua hàng</div>
                        <div class="small text-muted">Bạn có thể xem chi tiết các đơn hàng của khách này trong mục <a href="{{ route('admin.orders.index') }}?user_id={{ $user->ID }}" class="text-primary fw-bold">Quản lý đơn hàng</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center text-muted mt-5 pt-3 border-top small">
        © {{ date('Y') }} Hiên Sách - Hệ thống quản trị người dùng an toàn
    </div>
</div>
@endsection