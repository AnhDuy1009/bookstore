@extends('layouts.admin')

@section('title', 'Thêm sách mới')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>THÊM SÁCH MỚI</h1>
        <p class="welcome">Khởi tạo tác phẩm mới vào hệ thống Hiên Sách</p>
    </div>

    <div class="admin-welcome">
        <div class="welcome-text">
            Trạng thái: <span class="admin-name">Đang soạn thảo</span>
        </div>
        <div class="action-buttons">
            <a href="{{ route('books.index') }}" class="btn btn-outline">
                <i class="fas fa-list"></i> Danh sách sách
            </a>
        </div>
    </div>

    <div class="admin-content">
        <div class="form-card">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group form-span-2">
                        <label><i class="fas fa-heading"></i> Tên sách</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Ví dụ: Lược Sử Thời Gian">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user-feather"></i> Tác giả</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author') }}" required placeholder="Nhập tên tác giả">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tags"></i> Danh mục sách</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->ID }}" {{ old('category_id') == $cat->ID ? 'selected' : '' }}>
                                    {{ $cat->TenDanhMuc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Giá bán (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-boxes"></i> Số lượng trong kho</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" min="0">
                    </div>

                    <div class="form-group form-span-2">
                        <label><i class="fas fa-align-left"></i> Mô tả nội dung</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Nhập tóm tắt hoặc nội dung chính của sách...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4"> <label class="form-label fw-bold"><i class="fas fa-image"></i> Ảnh bìa sách</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text mt-1">* Định dạng hỗ trợ: JPG, PNG, WEBP (Dưới 2MB)</div>
                    </div>
                </div>

                <div class="pt-3 border-top"> <button type="reset" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-sync-alt"></i> Nhập lại
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Lưu sách mới
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            Hiên Sách Admin Panel &copy; 2026
        </div>
    </div>
</div>
@endsection