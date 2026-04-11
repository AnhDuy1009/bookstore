@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold text-center">Thanh toán đơn hàng</h2>
    <form action="{{ route('order.process') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h4 class="mb-4 fw-bold">Thông tin giao hàng</h4>
                    <div class="mb-3">
                        <label class="form-label text-muted">Họ và tên người nhận</label>
                        <input type="text" class="form-control form-control-lg" name="HoTen" value="{{ Auth::user()->HoTen ?? Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Số điện thoại</label>
                        <input type="tel" class="form-control form-control-lg" name="SDT" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" name="DiaChi" rows="3" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-muted">Mã giảm giá (Nếu có)</label>
                        <input type="text" class="form-control form-control-lg" name="VoucherCode" placeholder="Ví dụ: SALE50">
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="mb-4 fw-bold">Phương thức thanh toán</h4>
                    <div class="form-check mb-3">
                        <input class="form-check-input fs-5" type="radio" name="PhuongThucThanhToan" value="cod" id="pay_cod" checked>
                        <label class="form-check-label fs-5 ms-2" for="pay_cod">
                            Tiền mặt khi nhận hàng (COD)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input fs-5" type="radio" name="PhuongThucThanhToan" value="momo" id="pay_momo">
                        <label class="form-check-label fs-5 ms-2" for="pay_momo">
                            Thanh toán qua Ví MoMo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input fs-5" type="radio" name="PhuongThucThanhToan" value="vnpay" id="pay_vnpay">
                        <label class="form-check-label fs-5 ms-2" for="pay_vnpay">
                            Cổng thanh toán VNPay
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #f8f9fa;">
                    <h4 class="mb-4 fw-bold">Tóm tắt đơn hàng</h4>
                    
                    @php $total = 0; @endphp
                    @if(session('cart'))
                        <div class="mb-4">
                            @foreach(session('cart') as $item)
                                @php $total += $item['price'] * $item['quantity']; @endphp
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $item['title'] ?? $item['name'] ?? 'Tên sách' }}</h6>
                                        <small class="text-muted">Số lượng: {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="fw-bold">{{ number_format($item['price'] * $item['quantity']) }}đ</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Giỏ hàng trống.</p>
                    @endif
                    
                    <hr class="text-muted">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold">{{ number_format($total) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="fw-bold">30,000đ</span>
                    </div>
                    
                    <hr class="text-muted">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 mb-0 fw-bold">Tổng cộng:</span>
                        <span class="h4 mb-0 fw-bold text-danger">{{ number_format($total + 30000) }}đ</span>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-pill py-3">
                        XÁC NHẬN ĐẶT HÀNG
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection