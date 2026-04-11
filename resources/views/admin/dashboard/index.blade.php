@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<style>
   
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .bg-primary-light { background-color: #e7f1ff; }
    .bg-warning-light { background-color: #fff7e6; }
    .bg-success-light { background-color: #e6f9f0; }
    .bg-info-light { background-color: #e7f6f8; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">Tổng quan hệ thống</h3>
        <div class="badge bg-white text-muted shadow-sm p-2 px-3 border">
            <i class="far fa-calendar-alt me-1"></i> Ngày hiện tại: {{ date('d/m/Y') }}
        </div>
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
                        <h4 class="fw-bold m-0 text-primary">{{ number_format($currentMonthRevenue) }}đ</h4>
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
                        <div class="text-muted small">Đơn hàng mới</div>
                        <h4 class="fw-bold m-0 text-warning">{{ $newOrdersCount }}</h4>
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
                        <h4 class="fw-bold m-0 text-success">+{{ $newUsersCount }}</h4>
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
                        <div class="text-muted small">Đầu sách trong kho</div>
                        <h4 class="fw-bold m-0 text-info">{{ $totalStock }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold"><i class="fas fa-chart-line text-primary me-2"></i> Xu hướng doanh thu 7 ngày</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="min-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold m-0"><i class="fas fa-clipboard-list text-primary me-2"></i> Đơn hàng gần đây</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary border-0">Xem tất cả</a>
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
                                        @if($order->TrangThai == 'Hoàn thành' || $order->TrangThai == 'Đã giao' || $order->TrangThai == 'DONE' || $order->TrangThai == 'PAID')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @elseif($order->TrangThai == 'Đã hủy' || $order->TrangThai == 'CANCEL')
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $order->TrangThai }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                                        <p class="mb-0">Chưa có đơn hàng nào cần xử lý</p>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const labels = {!! json_encode($days) !!};
        const revenues = {!! json_encode($revenues) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu',
                    data: revenues,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection