@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>QUẢN LÝ DANH MỤC</h1>
        <p class="welcome">Danh sách các thể loại sách trong hệ thống</p>
    </div>

    <div class="admin-welcome">
        <div class="welcome-text">
            Xin chào, <span class="admin-name">{{ Auth::user()->HoTen ?? 'Admin' }}</span>
        </div>
        <div>{{ date('d/m/Y H:i:s') }}</div>
    </div>

    <div class="admin-content">
        <div class="toolbar">
            <form class="search-form" method="GET" action="{{ route('categories.index') }}">
                <input name="q" placeholder="Tìm theo tên danh mục..." value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit">Tìm</button>
            </form>

            <div class="action-buttons">
                <a class="btn btn-primary" href="{{ route('categories.create') }}">
                    <i class="fas fa-plus"></i> Thêm danh mục
                </a>
                <a class="btn btn-outline" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="card card-pad" style="border-left: 5px solid #22c55e; background-color: #f0fff4; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="color: #22c55e; font-size: 1.2rem;"></i>
                    <span style="color: #155724; font-weight: 600;">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="card card-pad" style="border-left: 5px solid #e53e3e; background-color: #fff5f5; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-exclamation-triangle" style="color: #e53e3e; font-size: 1.2rem;"></i>
                    <span style="color: #721c24; font-weight: 600;">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>Tên Danh Mục</th>
                        <th style="width: 180px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>#{{ $category->ID }}</td>
                            <td><strong style="color: #2d3748;">{{ $category->TenDanhMuc }}</strong></td>
                            <td>
                                <a class="link-edit" href="{{ route('categories.edit', $category->ID) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <span style="color: #cbd5e1; margin: 0 8px;">|</span>
                                <form action="{{ route('categories.destroy', $category->ID) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xác nhận xóa danh mục này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-delete" style="background:none; border:none; cursor:pointer; font-weight:800;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 30px; color: #718096;">
                                Không có dữ liệu danh mục.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px;">
            {{ $categories->appends(request()->query())->links() }}
        </div>
        
        <div class="footer">
            © {{ date('Y') }} Hiên Sách - Hệ thống Quản trị
        </div>
    </div>
</div>
@endsection