@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <img src="{{ $user->AnhDaiDien ? asset('storage/' . $user->AnhDaiDien) : asset('images/default-avatar.png') }}" 
     class="rounded-circle shadow" 
     style="width: 120px; height: 120px; object-fit: cover;">
                    <h3 class="fw-bold">{{ $user->HoTen }}</h3>
                    <p class="text-muted">{{ $user->Email }}</p>

                    <div class="row mt-4 border-top pt-4">
                        <div class="col-6 border-end">
                            <h5 class="mb-0 fw-bold">{{ $order_count }}</h5>
                            <small class="text-muted">Đơn hàng</small>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0 fw-bold text-primary">{{ number_format($total_spent) }}đ</h5>
                            <small class="text-muted">Đã chi tiêu</small>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-center gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary px-4">
                            <i class="fas fa-user-edit"></i> Chỉnh sửa
                        </a>
                        
                        <a href="{{ route('order.list') }}" class="btn btn-primary px-4">
                            <i class="fas fa-history"></i> Lịch sử mua hàng
                        </a>
                        <a href="{{ route('profile.reviews') }}" class="btn btn-warning px-4 text-white">
                            <i class="fas fa-star"></i> Đánh giá của tôi
                        </a>
                        {{-- Kiểm tra nếu là Admin thì mới hiển thị nút này --}}
                       @if(Auth::check() && trim(strtolower(Auth::user()->VaiTro)) == 'admin')
                            <a href="{{ url('/admin/orders') }}" class="btn btn-dark px-4 ms-2">
                                <i class="fas fa-user-shield me-1"></i> Quản lý hệ thống
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection