@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-comments"></i> QUẢN LÝ ĐÁNH GIÁ</h4>
            <p class="text-muted small mb-0">Phê duyệt hoặc xóa các phản hồi từ khách hàng</p>
        </div>
        <div class="text-end text-muted small">
            <div>Xin chào, <span class="fw-bold text-dark">{{ Auth::user()->HoTen ?? 'Admin' }}</span></div>
            <div>{{ date('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fw-bold fs-5 text-dark">
            <i class="fas fa-list-ul me-2"></i>Danh sách phản hồi
        </div>
        <div class="action-buttons">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 200px;">Sách</th>
                    <th style="width: 150px;">Người dùng</th>
                    <th style="width: 120px;" class="text-center">Xếp hạng</th>
                    <th>Nội dung đánh giá</th>
                    <th style="width: 130px;" class="text-center">Trạng thái</th>
                    <th style="width: 150px;" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>
                        <strong class="text-primary">{{ $review->book->TenSach ?? 'Sách #'.$review->IDSach }}</strong>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $review->user->HoTen ?? 'User #'.$review->IDNguoiDung }}</div>
                        <small class="text-muted">{{ $review->created_at ? $review->created_at->format('d/m/Y') : '' }}</small>
                    </td>
                    <td class="text-center text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= ($review->SoSao ?? 5) ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </td>
                    <td>
                        <div class="review-box text-muted" style="font-style: italic; max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                            "{{ $review->NoiDung }}"
                        </div>
                    </td>
                    <td class="text-center">
                        @if($review->TrangThai == 'approved' || $review->TrangThai == 'Đã duyệt')
                            <span class="badge bg-success">Đã duyệt</span>
                        @else
                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            @if($review->TrangThai != 'approved' && $review->TrangThai != 'Đã duyệt')
                            <form action="{{ route('admin.reviews.approve', $review->ID) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" title="Duyệt">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review->ID) }}" method="POST" onsubmit="return confirm('Xác nhận xóa đánh giá này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-comment-slash fa-3x mb-3 text-light"></i>
                        <p class="mb-0">Chưa có đánh giá nào được gửi lên.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    <div class="text-center text-muted mt-4 pt-3 border-top small">
        © {{ date('Y') }} Hiên Sách - Hệ thống Quản trị phản hồi
    </div>
</div>
@endsection