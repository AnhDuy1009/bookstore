@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Tổng quan hệ thống</h3>
        <div class="text-muted small">Ngày hiện tại: {{ date('d/m/Y') }}</div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-light text-primary me-3">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Doanh thu tháng</div>
                        <h4 class="fw-bold m-0">{{ number_format($currentMonthRevenue) }}đ</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning-light text-warning me-3">
                        <i class="fas fa-shopping-bag fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Đơn hàng xử lý</div>
                        <h4 class="fw-bold m-0">{{ $newOrdersCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success-light text-success me-3">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Khách hàng mới</div>
                        <h4 class="fw-bold m-0">+{{ $newUsersCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-info-light text-info me-3">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Sách trong kho</div>
                        <h4 class="fw-bold m-0">{{ $totalStock }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-2">
                    <h5 class="fw-bold"><i class="fas fa-clipboard-list text-primary me-2"></i> Đơn hàng gần đây</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#{{ $order->ID }}</td>
                                    
                                    <td class="fw-bold">{{ $order->HoTen ?? ($order->user->HoTen ?? 'Khách hàng') }}</td>
                                    
                                    <td>{{ date('d/m/Y H:i', strtotime($order->NgayDat)) }}</td>
                                    
                                    <td class="text-danger fw-bold">{{ number_format($order->TongTien) }}đ</td>
                                    
                                    <td>
                                        @if($order->TrangThai == 'Hoàn thành' || $order->TrangThai == 'Đã giao')
                                            <span class="badge bg-success">{{ $order->TrangThai }}</span>
                                        @elseif($order->TrangThai == 'Đã hủy')
                                            <span class="badge bg-danger">{{ $order->TrangThai }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $order->TrangThai }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-box-open fa-2x mb-2"></i>
                                        <p class="mb-0">Chưa có đơn hàng nào</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection