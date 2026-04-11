@extends('layouts.admin')

@php
    $isEdit = isset($category);
    $title = $isEdit ? 'SỬA DANH MỤC' : 'THÊM DANH MỤC';
    $subTitle = $isEdit ? 'Cập nhật thông tin danh mục hệ thống' : 'Khởi tạo danh mục sách mới';
@endphp

@section('title', $title)

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-edit"></i> {{ $title }}</h4>
            <p class="text-muted small mb-0">{{ $subTitle }}</p>
        </div>
        <div class="text-end">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-chevron-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $isEdit ? route('admin.categories.update', $category->ID) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row mb-4">
            <div class="col-md-8 col-lg-6">
                <div class="mb-3">
                    <label for="TenDanhMuc" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" name="TenDanhMuc" id="TenDanhMuc" 
                           class="form-control form-control-lg @error('TenDanhMuc') is-invalid @enderror" 
                           value="{{ old('TenDanhMuc', $category->TenDanhMuc ?? '') }}" 
                           required placeholder="Ví dụ: Văn học Kinh điển, Kinh tế tri thức...">
                    
                    @error('TenDanhMuc')
                        <div class="invalid-feedback fw-bold">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="text-muted small mt-2">
                    <i class="fas fa-info-circle"></i> Tên danh mục sẽ được hiển thị trên menu chính của website người dùng.
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4 me-2">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save"></i> {{ $isEdit ? 'Cập nhật ngay' : 'Lưu danh mục' }}
            </button>
        </div>
    </form>
</div>
@endsection