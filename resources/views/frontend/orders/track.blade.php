@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Chi tiết đơn hàng #{{ $order->MaDonHang }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Thông tin người nhận</h6>
                    <p class="mb-1"><strong>{{ $order->user->HoTen }}</strong></p>
                    <p class="mb-1">SĐT: {{ $order->SoDienThoai }}</p>
                    <p class="mb-0">Địa chỉ: {{ $order->DiaChiGiaoHang }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6>Trạng thái đơn hàng</h6>
                    <span class="badge bg-warning text-dark">{{ $order->TrangThai }}</span>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->details && $order->details->count() > 0)
                        @foreach($order->details as $detail)
                            <tr>
                                <td>{{ $detail->book->TenSach ?? 'Không xác định' }}</td>
                                <td class="text-center">{{ $detail->SoLuong }}</td>
                                <td class="text-end">{{ number_format($detail->GiaBan) }}đ</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center text-muted">Không tìm thấy chi tiết sản phẩm.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            <div class="row justify-content-end mt-4">
                <div class="col-md-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->TongTien - $order->PhiShip) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí ship:</span>
                        <span>{{ number_format($order->PhiShip) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between h5 text-danger fw-bold">
                        <span>Tổng tiền:</span>
                        <span>{{ number_format($order->TongTien) }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection