@extends('layouts.admin')

@section('title', 'Thống kê & Báo cáo')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-chart-line"></i> THỐNG KÊ & BÀO CÁO CHUYÊN SÂU</h4>
            <p class="text-muted small mb-0">Phân tích doanh thu và hiệu quả kinh doanh của Hiên Sách</p>
        </div>
        <div class="text-end text-muted small">
            <div>Cập nhật lúc: {{ date('H:i d/m/Y') }}</div>
        </div>
    </div>

    <div class="card bg-light border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.statistics.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Từ ngày</label>
                    <input type="date" name="tu" class="form-control" value="{{ $tu }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Đến ngày</label>
                    <input type="date" name="den" class="form-control" value="{{ $den }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-filter"></i> Lọc dữ và Báo cáo</button>
                    <a href="{{ route('admin.statistics.index') }}" class="btn btn-outline-secondary">Làm mới</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="alert alert-info border-0 shadow-sm mb-4 d-flex justify-content-between align-items-center no-print">
        <div>
            <h6 class="fw-bold mb-1"><i class="fas fa-file-export"></i> TRÍCH XUẤT DỮ LIỆU</h6>
            <p class="small mb-0 text-dark">Xuất tệp báo cáo chi tiết từ ngày <strong>{{ date('d/m/Y', strtotime($tu)) }}</strong> đến <strong>{{ date('d/m/Y', strtotime($den)) }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.statistics.export', ['tu' => $tu, 'den' => $den]) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Xuất Excel (.xlsx)
            </a>
            <button class="btn btn-dark ms-2" onclick="window.print()">
                <i class="fas fa-print"></i> In trang này
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="p-4 rounded-4 shadow-sm text-white" style="background: linear-gradient(135deg, #27ae60, #1e8449);">
                <div class="small opacity-75 fw-bold mb-1"><i class="fas fa-money-bill-wave"></i> TỔNG DOANH THU</div>
                <div class="display-6 fw-bold">{{ number_format($revenueData->DoanhThu ?? 0) }} đ</div>
                <div class="mt-2 small">Dựa trên các đơn hàng đã hoàn thành</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 rounded-4 shadow-sm text-white" style="background: linear-gradient(135deg, #2980b9, #1b4f72);">
                <div class="small opacity-75 fw-bold mb-1"><i class="fas fa-shopping-cart"></i> ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="display-6 fw-bold">{{ $revenueData->SoDon ?? 0 }} <small class="fs-4">đơn</small></div>
                <div class="mt-2 small">Số lượng giao dịch thành công</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-dark"><i class="fas fa-trophy text-warning me-2"></i> Top 10 Sách Bán Chạy Nhất</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small fw-bold text-muted text-uppercase">
                                <tr>
                                    <th class="ps-4">Tên sách</th>
                                    <th class="text-center">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellers as $book)
                                <tr>
                                    <td class="ps-4 py-3 fw-bold text-dark">{{ $book->TenSach }}</td>
                                    <td class="text-center"><span class="badge bg-success rounded-pill px-3">{{ $book->TongBan }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4 text-muted small italic">Không có dữ liệu</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-dark"><i class="fas fa-star text-orange me-2"></i> Khách Hàng Thân Thiết nhất</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small fw-bold text-muted text-uppercase">
                                <tr>
                                    <th class="ps-4">Thông tin khách hàng</th>
                                    <th class="text-center">Số đơn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topUsers as $user)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $user->HoTen }}</div>
                                        <div class="small text-muted">{{ $user->Email }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark rounded-pill px-3 fw-bold">{{ $user->SoDon }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4 text-muted small italic">Không có dữ liệu</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center text-muted mt-5 pt-3 border-top small">
        <p class="mb-1">© {{ date('Y') }} <strong>Hiên Sách</strong> - Hệ thống Báo cáo Kinh doanh Đồ án Chuyên ngành</p>
        <p class="small italic text-muted">Báo cáo được tạo tự động bởi hệ thống quản trị, thời gian xuất: {{ date('H:i:s d/m/Y') }}</p>
    </div>
</div>


@endsection