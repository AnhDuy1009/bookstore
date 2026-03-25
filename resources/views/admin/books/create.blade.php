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
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group form-span-2">
                        <label><i class="fas fa-heading"></i> Tên sách</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ví dụ: Lược Sử Thời Gian">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user-feather"></i> Tác giả</label>
                        <input type="text" name="author" value="{{ old('author') }}" required placeholder="Nhập tên tác giả">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tags"></i> Danh mục sách</label>
                        <select name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Giá bán (VNĐ)</label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-boxes"></i> Số lượng trong kho</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0">
                    </div>

                    <div class="form-group form-span-2">
                        <label><i class="fas fa-align-left"></i> Mô tả nội dung</label>
                        <textarea name="description" placeholder="Nhập tóm tắt hoặc nội dung chính của sách...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group form-span-2">
                        <label><i class="fas fa-image"></i> Ảnh bìa sách</label>
                        <input type="file" name="image" accept="image/*">
                        <small style="color: #718096; margin-top: 5px;">* Định dạng hỗ trợ: JPG, PNG, WEBP (Dưới 2MB)</small>
                    </div>
                </div>

                <div class="form-actions" style="border-top: 1px solid #eee; padding-top: 20px;">
                    <button type="reset" class="btn btn-outline">
                        <i class="fas fa-undo"></i> Nhập lại
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Lưu sách mới
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