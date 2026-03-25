@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>QUẢN LÝ ĐÁNH GIÁ</h1>
        <p class="welcome">Duyệt hoặc xóa các đánh giá từ khách hàng</p>
    </div>

    <div class="admin-welcome">
        <div class="welcome-text">
            Xin chào, <span class="admin-name">{{ Auth::user()->HoTen ?? 'Admin' }}</span>
        </div>
        <div>{{ date('d/m/Y H:i:s') }}</div>
    </div>

    <div class="admin-content">
        <div class="toolbar">
            <div style="font-size:20px; font-weight:800; color:#2d3748;">
                Danh sách phản hồi
            </div>
            <div class="action-buttons">
                <a class="btn btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="card card-pad" style="border-left: 5px solid #2ecc71; background: #f0fff4; margin-bottom: 20px;">
                <i class="fas fa-check-circle" style="color: #2ecc71;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-wrap card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 150px;">Sách</th>
                        <th style="width: 150px;">Người dùng</th>
                        <th>Nội dung đánh giá</th>
                        <th style="width: 120px;">Trạng thái</th>
                        <th style="width: 180px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>
                            <strong style="color: #667eea;">{{ $review->book->TenSach ?? 'Sách #'.$review->IDSach }}</strong>
                        </td>
                        <td>{{ $review->user->HoTen ?? 'User #'.$review->IDNguoiDung }}</td>
                        <td class="review-box" style="font-style: italic; color: #4a5568;">
                            "{{ $review->NoiDung }}"
                        </td>
                        <td>
                            @if($review->TrangThai == 'approved')
                                <span class="badge badge-green">Đã duyệt</span>
                            @else
                                <span class="badge badge-gray">Chờ xử lý</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($review->TrangThai != 'approved')
                                <form action="{{ route('reviews.approve', $review->ID) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background: #2ecc71; border: none;">
                                        Duyệt
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('reviews.destroy', $review->ID) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xác nhận xóa đánh giá này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="link-delete" style="background:none; border:none; cursor:pointer;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #a0aec0;">
                            Chưa có đánh giá nào được gửi lên.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $reviews->links() }}
        </div>
    </div>

    <div class="footer">
        © {{ date('Y') }} Hiên Sách - Hệ thống Quản trị
    </div>
</div>
@endsection