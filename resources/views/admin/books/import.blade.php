@extends('layouts.admin')

@section('title', 'Nhập dữ liệu sách từ CSV')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-file-import"></i> NHẬP DỮ LIỆU TỪ CSV</h4>
            <p class="text-muted small mb-0">Thêm nhanh hàng loạt sách vào hệ thống qua file Excel/CSV</p>
        </div>
        <div class="text-end text-muted small">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.books.index') }}">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="p-3 bg-light rounded border">
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle text-info"></i> Hướng dẫn cấu trúc file</h6>
                <p class="small text-muted">File CSV của bạn phải có các cột theo thứ tự sau (ngăn cách bởi dấu phẩy):</p>
                
                <div class="bg-dark text-white p-2 rounded mb-3">
                    <code class="text-warning">title, author, price, stock, category_id, description</code>
                </div>

                <ul class="small text-muted ps-3">
                    <li><strong>title:</strong> Tên sách (không để trống).</li>
                    <li><strong>author:</strong> Tên tác giả.</li>
                    <li><strong>price:</strong> Giá bán (số nguyên).</li>
                    <li><strong>stock:</strong> Số lượng tồn kho.</li>
                    <li><strong>category_id:</strong> ID của danh mục (Xem ở trang Quản lý danh mục).</li>
                    <li><strong>description:</strong> Mô tả ngắn về sách.</li>
                </ul>
                
                <div class="alert alert-warning py-2 mb-0">
                    <small><i class="fas fa-exclamation-triangle"></i> Lưu ý: Lưu file ở định dạng <strong>CSV UTF-8</strong> để không bị lỗi font tiếng Việt.</small>
                </div>
            </div>
        </div>

        <div class="col-md-7">
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

            <div class="p-4 border rounded bg-white shadow-sm">
                <form action="{{ route('admin.books.import.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Chọn file dữ liệu</h5>
                        <p class="text-muted small">Kéo thả hoặc nhấn để chọn file .csv</p>
                    </div>

                    <div class="mb-4">
                        <input type="file" name="csv_file" class="form-control form-control-lg @error('csv_file') is-invalid @enderror" accept=".csv" required>
                        @error('csv_file')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-upload me-2"></i> Bắt đầu nhập dữ liệu
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">© {{ date('Y') }} Hiên Sách Admin Panel - Hệ thống nhập dữ liệu thông minh</p>
            </div>
        </div>
    </div>
</div>
@endsection