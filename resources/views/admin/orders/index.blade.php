@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #ff9f43;">DANH SÁCH ĐƠN HÀNG</h5>
        <div class="small text-muted">{{ date('d/m/Y H:i') }}</div>
    </div>

    <div class="card-body">
        <form class="row g-2 mb-4" method="GET" action="{{ route('admin.orders.index') }}">
            <div class="col-auto">
                <input type="text" name="status" class="form-control form-control-sm" 
                       value="{{ request('status') }}" placeholder="Lọc trạng thái...">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm text-white" type="submit" style="background-color: #ff9f43;">Lọc</button>
                @if(request('status'))
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.orders.index') }}">Xóa lọc</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold">#{{ $order->ID }}</td>
                            <td class="text-danger fw-bold">{{ number_format($order->TongTien) }}đ</td>
                            <td>
                                @php
                                    $st = strtolower($order->TrangThai);
                                    $color = 'secondary';
                                    if(in_array($st, ['paid','done'])) $color = 'success';
                                    if(in_array($st, ['cancel','failed'])) $color = 'danger';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $order->TrangThai }}</span>
                            </td>
                            <td>{{ $order->NgayTao }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order->ID) }}" class="btn btn-sm btn-outline-info">Chi tiết</a>
                                <a href="{{ route('admin.orders.print', $order->ID) }}" target="_blank" class="btn btn-sm btn-outline-dark">In</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">Chưa có đơn hàng nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection