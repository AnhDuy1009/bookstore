@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="card border-0 shadow-sm p-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
        <h5 class="fw-bold m-0" style="color: #000000;"><i class="fas fa-clipboard-list me-2"></i> DANH SÁCH ĐƠN HÀNG</h5>
        <div class="small text-muted">Cập nhật: {{ date('d/m/Y H:i') }}</div>
    </div>

    <div class="card-body pt-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form class="row g-2 mb-4 align-items-center" method="GET" action="{{ route('admin.orders.index') }}">
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="fas fa-filter text-muted"></i></span>
                    <input type="text" name="status" class="form-control" 
                           value="{{ request('status') }}" placeholder="Lọc trạng thái...">
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm text-white px-3" type="submit" style="background-color: #ff9f43;">Lọc dữ liệu</button>
                @if(request('status'))
                    <a class="btn btn-sm btn-outline-secondary ms-1" href="{{ route('admin.orders.index') }}">Xóa lọc</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold text-muted ps-3">#{{ $order->ID }}</td>
                            
                            <td class="fw-bold text-dark">
                                {{ $order->HoTen ?? ($order->user->HoTen ?? 'Khách lẻ') }}
                            </td>
                            
                            <td class="text-danger fw-bold">{{ number_format($order->TongTien) }}đ</td>
                            
                            <td>
                                @php
                                    $st = $order->TrangThai;
                                    $color = 'secondary';
                                    if(in_array(strtolower($st), ['paid','done']) || $st == 'Hoàn thành' || $st == 'Đã giao') $color = 'success';
                                    elseif(in_array(strtolower($st), ['cancel','failed']) || $st == 'Đã hủy') $color = 'danger';
                                    elseif($st == 'Đang xử lý' || strtolower($st) == 'pending') $color = 'warning text-dark';
                                    elseif($st == 'Đang giao') $color = 'info text-dark';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $order->TrangThai }}</span>
                            </td>
                            
                            <td class="text-muted small">
                                {{ date('d/m/Y H:i', strtotime($order->NgayTao ?? ($order->NgayDat ?? now()))) }}
                            </td>
                            
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order->ID) }}" class="btn btn-sm btn-outline-info me-1" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a href="{{ route('admin.orders.print', $order->ID) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="In hóa đơn">
                                    <i class="fas fa-print"></i> In
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                                <p class="mb-0">Chưa có đơn hàng nào trong hệ thống.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="pagination-wrapper w-100">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection