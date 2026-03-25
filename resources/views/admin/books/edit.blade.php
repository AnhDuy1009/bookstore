@extends('layouts.admin')

@section('title', 'Chỉnh sửa: ' . $book->TenSach)

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>CHỈNH SỬA SÁCH</h1>
        <p class="welcome">Đang cập nhật thông tin cho tác phẩm: <strong>{{ $book->TenSach }}</strong></p>
    </div>

    <div class="admin-welcome">
        <div class="welcome-text">
            Mã sách: <span class="admin-name">#{{ $book->ID }}</span>
        </div>
        <div class="action-buttons">
            <a href="{{ route('books.index') }}" class="btn btn-outline">
                <i class="fas fa-chevron-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-content">
        <div class="form-card">
            <form action="{{ route('books.update', $book->ID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-group form-span-2">
                        <label>Tên sách</label>
                        <input type="text" name="TenSach" value="{{ $book->TenSach }}" required placeholder="Nhập tên sách...">
                    </div>

                    <div class="form-group">
                        <label>Giá bán (VNĐ)</label>
                        <input type="number" name="GiaBan" value="{{ $book->GiaBan }}" placeholder="0">
                    </div>

                    <div class="form-group">
                        <label>Trạng thái hiển thị</label>
                        <select name="TrangThai">
                            <option value="Active" {{ $book->TrangThai == 'Active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="Inactive" {{ $book->TrangThai == 'Inactive' ? 'selected' : '' }}>Tạm ẩn</option>
                        </select>
                    </div>

                    <div class="form-group form-span-2">
                        <label>Mô tả chi tiết</label>
                        <textarea name="MoTa" placeholder="Nhập tóm tắt nội dung...">{{ $book->MoTa }}</textarea>
                    </div>

                    <div class="form-group form-span-2">
                        <label>Ảnh bìa sách</label>
                        @if($book->Link_Anh_Bia)
                            <div style="margin-bottom: 12px;">
                                <p style="font-size: 13px; color: #718096; margin-bottom: 5px;">Ảnh hiện tại:</p>
                                <img src="{{ asset($book->Link_Anh_Bia) }}" class="thumb" style="width: 100px; height: 140px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="Anh_Bia_File">
                        <small style="color: #a0aec0; margin-top: 5px;">* Để trống nếu không muốn thay đổi ảnh.</small>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('books.index') }}" class="btn btn-outline">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật thay đổi
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            Hệ thống quản trị Hiên Sách &copy; 2026
        </div>
    </div>
</div>
@endsection