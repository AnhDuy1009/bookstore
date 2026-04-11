@extends('layouts.admin')
@section('title', 'Quản lý kho sách')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-book"></i> Danh sách sách</h4>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm sách mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-hover align-middle"> <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ảnh bìa</th> 
                    <th>Tên sách</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="fw-bold text-muted">#{{ $book->ID }}</td>
                    
                    <td>
                        @if(isset($book->Link_image) && $book->Link_image != '')
                            @php
                                $cleanPath = str_replace(['public/', 'storage/', '\\'], ['', '', '/'], $book->Link_image);
                            @endphp
                            <img src="{{ asset('storage/' . $cleanPath) }}" alt="Ảnh bìa" class="shadow-sm" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 50px; height: 70px; border-radius: 4px; border: 1px dashed #ccc;">
                                <i class="fas fa-image fs-5"></i>
                            </div>
                        @endif
                    </td>

                    <td class="fw-bold">{{ $book->TenSach }}</td>
                    
                    <td class="text-danger fw-bold">{{ number_format($book->GiaBan) }}đ</td>
                    
                    <td>
                        @if($book->SoLuongTon > 10)
                            <span class="badge bg-success">{{ $book->SoLuongTon }} cuốn</span>
                        @elseif($book->SoLuongTon > 0)
                            <span class="badge bg-warning text-dark">{{ $book->SoLuongTon }} cuốn</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif
                    </td>

                    <td>
                        @if($book->TrangThai == 'Hoạt động' || $book->TrangThai == 'Active')
                            <span class="badge bg-primary">Hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Tạm ẩn</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.books.edit', $book->ID) }}" class="btn btn-sm btn-info text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
                        
                        <form action="{{ route('admin.books.destroy', $book->ID) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white border-top-0 pt-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="pagination-wrapper w-100">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</div>
@endsection