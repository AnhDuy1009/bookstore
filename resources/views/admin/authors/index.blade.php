@extends('layouts.admin')

@section('title', 'Quản lý Tác giả')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-pen-nib"></i> QUẢN LÝ TÁC GIẢ</h4>
            <p class="text-muted small mb-0">Danh sách các tác giả có sách trong hệ thống</p>
        </div>
        <div class="text-end text-muted small">
            <div class="fw-bold text-dark">Xin chào, {{ Auth::user()->HoTen ?? 'Admin' }}</div>
            <div>{{ date('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form class="d-flex" method="GET" action="{{ route('admin.authors.index') }}">
            <input name="q" class="form-control me-2" placeholder="Tìm tên tác giả..." value="{{ request('q') }}">
            <button class="btn btn-outline-primary px-3" type="submit"><i class="fas fa-search"></i></button>
        </form>

        <div class="action-buttons">
            <a class="btn btn-primary" href="{{ route('admin.authors.create') }}">
                <i class="fas fa-plus"></i> Thêm tác giả
            </a>
            <a class="btn btn-outline-secondary ms-2" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th style="width: 100px;">Ảnh</th>
                    <th>Tên Tác Giả</th>
                    <th>Tiểu sử tóm tắt</th>
                    <th style="width: 150px;" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $author->ID }}</td>
                        <td>
                            @if($author->HinhAnh)
                                <img src="{{ asset('storage/' . $author->HinhAnh) }}" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #eee;">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 50px; height: 50px; border: 2px solid #eee;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong class="text-dark">{{ $author->TenTacGia }}</strong></td>
                        <td>
                            <div class="text-muted small" style="max-width: 350px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $author->TieuSu ?? 'Chưa có thông tin tiểu sử.' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.authors.edit', $author->ID) }}" class="btn btn-sm btn-info text-white" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.authors.destroy', $author->ID) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tác giả này? Tất cả sách liên quan có thể bị ảnh hưởng.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-user-edit fa-3x mb-3 text-light"></i>
                            <p class="mb-0">Chưa có dữ liệu tác giả nào.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $authors->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    <div class="text-center text-muted mt-5 pt-3 border-top small">
        © {{ date('Y') }} Hiên Sách - Quản lý nội dung Tác giả
    </div>
</div>
@endsection