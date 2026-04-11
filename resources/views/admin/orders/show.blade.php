@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->ID)

@section('content')
<div class="card border-0 shadow-sm p-4">
  
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-file-invoice"></i> CHI TIẾT ĐƠN HÀNG #{{ $order->ID }}</h4>
            <p class="text-muted small mb-0">Ngày tạo: {{ date('d/m/Y H:i', strtotime($order->NgayTao ?? $order->NgayDat ?? now())) }}</p>
        </div>
        <div class="text-end">
            <a class="btn btn-outline-secondary btn-sm me-2" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a class="btn btn-dark btn-sm" href="{{ route('admin.orders.print', $order->ID) }}" target="_blank">
                <i class="fas fa-print"></i> In hóa đơn
            </a>
        </div>
    </div>

   
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

   
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="p-3 bg-light rounded border h-100">
                <div class="text-muted small fw-bold mb-2"><i class="fas fa-user text-primary"></i> KHÁCH HÀNG</div>
                <div class="fw-bold text-dark fs-5">{{ $order->HoTen ?? ($order->user->HoTen ?? 'Khách lẻ') }}</div>
                <div class="text-muted small mt-1">Mã KH: #{{ $order->IDNguoiDung ?? 'Khách vãng lai' }}</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="p-3 bg-light rounded border h-100">
                <div class="text-muted small fw-bold mb-2"><i class="fas fa-money-bill-wave text-success"></i> TỔNG THANH TOÁN</div>
                <div class="fw-bold text-danger fs-4">{{ number_format($order->TongTien, 0, ',', '.') }} đ</div>
                <div class="text-muted small mt-1">Phương thức: Mặc định</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="p-3 bg-light rounded border h-100">
                <div class="text-muted small fw-bold mb-2"><i class="fas fa-info-circle text-info"></i> TRẠNG THÁI HIỆN TẠI</div>
                <div class="mt-2">
                    @php
                        $st = $order->TrangThai;
                        $color = 'secondary';
                        if(in_array(strtolower($st), ['paid','done']) || $st == 'Hoàn thành' || $st == 'Đã giao') $color = 'success';
                        elseif(in_array(strtolower($st), ['cancel','failed']) || $st == 'Đã hủy') $color = 'danger';
                        elseif($st == 'Đang xử lý' || strtolower($st) == 'pending' || strtolower($st) == 'new') $color = 'warning text-dark';
                        elseif($st == 'Đang giao' || strtolower($st) == 'shipping') $color = 'info text-dark';
                    @endphp
                    <span class="badge bg-{{ $color }} fs-6 px-3 py-2">{{ $order->TrangThai }}</span>
                </div>
            </div>
        </div>
    </div>

  
    <div class="card border border-warning mb-5 shadow-sm">
        <div class="card-header bg-warning bg-opacity-10 fw-bold text-dark py-3">
            <i class="fas fa-edit text-warning"></i> CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
        </div>
        <div class="card-body">
          
            <form action="{{ route('admin.orders.updateStatus', $order->ID) }}" method="POST" class="row align-items-end g-3">
                @csrf
                @method('PATCH')
                
                <div class="col-md-8 col-lg-6">
                    <label class="form-label text-muted small fw-bold">Chọn trạng thái mới:</label>
                    <div class="d-flex gap-2">
                        <select name="TrangThai" class="form-select border-warning">
                            <option value="Đang xử lý" {{ $order->TrangThai == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="Đang giao" {{ $order->TrangThai == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                            <option value="Đã giao" {{ $order->TrangThai == 'Đã giao' ? 'selected' : '' }}>Đã giao (Hoàn thành)</option>
                            <option value="Đã hủy" {{ $order->TrangThai == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark text-nowrap">
                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

</div>
@endsection