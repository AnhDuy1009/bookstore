@extends('layouts.admin')

@php
    $isEdit = isset($category);
    $title = $isEdit ? 'SỬA DANH MỤC' : 'THÊM DANH MỤC';
    $subTitle = $isEdit ? 'Cập nhật thông tin danh mục hệ thống' : 'Khởi tạo danh mục sách mới';
@endphp

@section('title', $title)

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>{{ $title }}</h1>
        <p class="welcome">{{ $subTitle }}</p>
    </div>

    <div class="admin-welcome">
        <div class="welcome-text">
            Đang thực hiện: <span class="admin-name">{{ $isEdit ? $category->TenDanhMuc : 'Mới' }}</span>
        </div>
        <div class="action-buttons">
            <a class="btn btn-outline" href="{{ route('categories.index') }}">
                <i class="fas fa-chevron-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="admin-content">
        @if($errors->any())
            <div class="card card-pad" style="border-left: 5px solid #f8d7da; margin-bottom: 20px;">
                <ul style="list-style: none; color: #721c24;">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ $isEdit ? route('categories.update', $category->ID) : route('categories.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="form-group form-span-2">
                        <label for="TenDanhMuc">Tên danh mục</label>
                        <input type="text" name="TenDanhMuc" id="TenDanhMuc" 
                               value="{{ old('TenDanhMuc', $category->TenDanhMuc ?? '') }}" 
                               required placeholder="Ví dụ: Văn học Kinh điển, Kinh tế tri thức...">
                        @error('TenDanhMuc')
                            <small style="color: #e53e3e; font-weight: 600; margin-top: 5px; display: block;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ $isEdit ? 'Cập nhật ngay' : 'Lưu danh mục' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="footer">
            Hiên Sách Admin Panel - Bảo mật & Hiệu quả
        </div>
    </div>
</div>
@endsection