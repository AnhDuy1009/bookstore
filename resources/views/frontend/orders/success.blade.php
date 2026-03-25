@extends('layouts.app')
@section('content')
<div class="container text-center py-5">
    <div class="card p-5 shadow border-0 mx-auto" style="max-width: 500px; border-radius: 20px;">
        <i class="fas fa-check-circle text-success mb-3" style="font-size: 70px;"></i>
        <h2 class="fw-bold">ĐẶT HÀNG THÀNH CÔNG!</h2>
        <p class="text-muted">Mã đơn hàng: <strong>#{{ $order_code }}</strong></p>
        <div class="bg-light p-3 rounded mb-4">
            <p class="mb-1">Phương thức: {{ $method }}</p>
            <p class="mb-0 text-success">Trạng thái: Đang xử lý</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary px-4">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection