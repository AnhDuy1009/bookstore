@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Đơn hàng của tôi</h3>
    <div class="d-flex gap-3 mb-4 border-bottom">
        @foreach(['Tất cả', 'Đang xử lý', 'Đã giao', 'Đã hủy'] as $status)
            <a href="?tab={{ $status }}" class="pb-2 text-decoration-none {{ $tab == $status ? 'border-bottom border-primary fw-bold' : 'text-muted' }}">
                {{ $status }}
            </a>
        @endforeach
    </div>

    @forelse($orders as $order)
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info mb-2">{{ $order->TrangThai }}</span>
                <p class="mb-1">Mã đơn: <strong>#{{ $order->MaDonHang }}</strong></p>
                <small class="text-muted">Ngày đặt: {{ $order->created_at->format('H:i d/m/Y') }}</small>
            </div>
            <div class="text-end">
                <p class="text-danger fw-bold mb-1">{{ number_format($order->TongTien) }}đ</p>
                <div class="d-flex align-items-center gap-2">
                <a href="{{ route('order.track', $order->id) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                @if($order->TrangThai == 'Đã giao')
                    <a href="{{ route('order.track', $order->ID) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-star"></i> Đánh giá
                    </a>
                @endif
                @if($order->TrangThai == 'Đang xử lý')
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" 
                        onsubmit="return confirm('Nghĩa ơi, bạn có chắc chắn muốn hủy đơn hàng này không?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                    </form>
                @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
    </div>
    @endforelse
</div>
@endsection