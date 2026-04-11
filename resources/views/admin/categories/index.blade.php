@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="card border-0 shadow-sm p-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-tags text-primary"></i> QUẢN LÝ DANH MỤC</h4>
            <p class="text-muted small mb-0">Danh sách các thể loại sách trong hệ thống</p>
        </div>
        <div class="text-end text-muted small">
            <div>Xin chào, <span class="fw-bold text-primary">{{ Auth::user()->HoTen ?? 'Admin' }}</span></div>
            <div>{{ date('d/m/Y H:i') }}</div>
        </div>
    </div>

    {{-- THANH CÔNG CỤ (Đã làm gọn lại) --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        
        <form method="GET" action="{{ route('admin.categories.index') }}" style="max-width: 300px; width: 100%;">
            <div class="input-group shadow-sm">
                <input name="q" class="form-control" placeholder="Tìm tên danh mục..." value="{{ request('q') }}">
                <button class="btn btn-primary px-3" type="submit">
                    <i class="fas fa-search"></i> Tìm
                </button>
            </div>
        </form>

        {{-- Cụm nút bấm --}}
        <div class="action-buttons d-flex gap-2">
            <a class="btn btn-primary shadow-sm" href="{{ route('admin.categories.create') }}">
                <i class="fas fa-plus me-1"></i> Thêm danh mục
            </a>
            <a class="btn btn-outline-secondary shadow-sm" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </div>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Bảng dữ liệu --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle border-bottom">
            <thead class="table-light">
                <tr>
                    <th style="width: 100px;" class="text-muted">ID</th>
                    <th class="text-muted">Tên Danh Mục</th>
                    <th style="width: 150px;" class="text-center text-muted">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $category->ID }}</td>
                        <td><strong class="text-dark">{{ $category->TenDanhMuc ?? $category->TenTheLoai }}</strong></td>
                        <td class="text-center">
                            <a href="{{ route('admin.categories.edit', $category->ID) }}" class="btn btn-sm btn-info text-white me-1 shadow-sm" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->ID) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xác nhận xóa danh mục này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                <i class="fas fa-folder-open fa-3x text-secondary"></i>
                            </div>
                            <p class="mb-0 fs-5">Không có dữ liệu danh mục.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="pagination-wrapper w-100">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
</div>
@endsection