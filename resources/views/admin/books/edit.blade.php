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
            <a href="{{ route('admin.books.index') }}" class="btn btn-outline">
                <i class="fas fa-chevron-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-content">
        <div class="form-card">
            <form action="{{ route('admin.books.update', $book->ID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-group form-span-2">
                        <label>Tên sách</label>
                        <input type="text" name="TenSach" class="form-control" value="{{ $book->TenSach }}" required placeholder="Nhập tên sách...">
                    </div>

                    <div class="form-group">
                        <label>Giá bán (VNĐ)</label>
                        <input type="number" class="form-control" name="GiaBan" value="{{ $book->GiaBan }}" placeholder="0">
                    </div>

                    <div class="form-group">
                        <label>Trạng thái hiển thị</label>
                        <select name="TrangThai" class="form-select">
                            <option value="Active" {{ $book->TrangThai == 'Active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="Inactive" {{ $book->TrangThai == 'Inactive' ? 'selected' : '' }}>Tạm ẩn</option>
                        </select>
                    </div>

                    <div class="form-group form-span-2">
                        <label>Mô tả chi tiết</label>
                        <textarea name="MoTa" class="form-control" rows="4" placeholder="Nhập tóm tắt nội dung...">{{ $book->MoTa }}</textarea>
                    </div>

                    <div class="form-group form-span-2">
                        <label>Ảnh bìa sách</label>
                        
                        <div style="margin-bottom: 12px;">
                            <p style="font-size: 13px; color: #718096; margin-bottom: 5px;">Ảnh hiện tại:</p>
                            
                            
                            @if(isset($book->Link_image) && $book->Link_image != '')
                                @php
                                    $cleanPath = str_replace(['public/', 'storage/', '\\'], ['', '', '/'], $book->Link_image);
                                @endphp
                                <img src="{{ asset('storage/' . $cleanPath) }}" class="thumb" style="width: 100px; height: 140px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                
                            
                            @elseif(isset($book->Link_Anh_Bia) && $book->Link_Anh_Bia != '')
                                <img src="{{ $book->Link_Anh_Bia }}" class="thumb" style="width: 100px; height: 140px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                
                           
                            @else
                                <div style="width: 100px; height: 140px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #aaa; border-radius: 4px; background-color: #f8f9fa;">
                                    <i class="fas fa-image" style="font-size: 24px;"></i>
                                </div>
                            @endif
                        </div>

                      
                        <input type="file" name="Anh_Bia_File" class="form-control" style="margin-top: 8px;">
                        <small style="color: #a0aec0; display: block; margin-top: 5px;">* Để trống nếu không muốn thay đổi ảnh.</small>
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