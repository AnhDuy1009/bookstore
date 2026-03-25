@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card p-4 shadow-sm border-0">
                <h3 class="mb-4">Thông tin giao hàng</h3>
                <form action="{{ route('order.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ và tên người nhận</label>
                        <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>
                    <h5 class="mt-4">Phương thức thanh toán</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="COD" checked>
                        <label class="form-check-label">Tiền mặt khi nhận hàng (COD)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="Momo">
                        <label class="form-check-label">Ví MoMo</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4">XÁC NHẬN ĐẶT HÀNG</button>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card p-4 bg-light border-0">
                <h4>Tóm tắt đơn hàng</h4>
                @foreach($cart as $item)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $item['title'] }} x{{ $item['quantity'] }}</span>
                    <span>{{ number_format($item['price'] * $item['quantity']) }}đ</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between h5">
                    <span>Tổng cộng:</span>
                    <span class="text-danger">{{ number_format($total + 30000) }}đ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection