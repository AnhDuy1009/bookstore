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
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold">Biểu đồ doanh thu 7 ngày</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold">Đơn hàng gần đây</h5>
                </div>
                <div class="card-body p-0">
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection