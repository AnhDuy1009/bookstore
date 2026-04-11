@extends('layouts.admin')

@section('title', 'Quản lý thành viên')

@section('content')
<div class="card border-0 shadow-sm rounded-3 p-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
        <h5 class="fw-bold m-0" style="color: #000000;"><i class="fas fa-users-cog me-2"></i> DANH SÁCH NGƯỜI DÙNG</h5>
        <div class="action-buttons">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm text-white" style="background-color: #ff9f43;">
                <i class="fas fa-user-plus me-1"></i> Thêm admin mới
            </a>
        </div>
    </div>

    <div class="card-body pt-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $user->ID ?? $user->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $user->HoTen }}</div>
                            <small class="text-muted">Tham gia: {{ date('d/m/Y', strtotime($user->NgayTao ?? $user->created_at)) }}</small>
                        </td>
                        <td>{{ $user->Email ?? $user->email }}</td>
                        <td>
                            @if(strtolower($user->VaiTro) == 'admin')
                                <span class="badge bg-danger px-3">Quản trị</span>
                            @else
                                <span class="badge bg-info text-dark px-3">Khách hàng</span>
                            @endif
                        </td>
                        <td>
                            @if($user->TrangThai == 'active' || $user->status == 'active' || $user->TrangThai == 'Hoạt động')
                                <span class="text-success small fw-bold"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> Đang hoạt động</span>
                            @else
                                <span class="text-danger small fw-bold"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> Đã khóa</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->ID ?? $user->id) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if(Auth::id() != ($user->ID ?? $user->id)) 
                                <form action="{{ route('admin.users.destroy', $user->ID ?? $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa tài khoản">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-3x mb-3 text-light"></i>
                            <p class="mb-0">Hệ thống chưa có người dùng nào.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="pagination-wrapper w-100">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    
    <div class="text-center text-muted mt-4 pt-3 border-top small">
        © {{ date('Y') }} Hiên Sách - Hệ thống Quản trị Người dùng
    </div>
</div>
@endsection