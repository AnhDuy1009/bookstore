@extends('layouts.admin')

@section('title', 'Thống kê & Báo cáo')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>THỐNG KÊ & BÁO CÁO CHUYÊN SÂU</h1>
        <p class="welcome">Phân tích doanh thu và hiệu quả kinh doanh</p>
    </div>

    <div class="admin-content">
        <div class="card card-pad" style="margin-bottom: 25px;">
            <form method="GET" action="{{ route('statistics.index') }}" class="search-form">
                <strong>Từ ngày:</strong>
                <input type="date" name="tu" value="{{ $tu }}">
                <strong>Đến ngày:</strong>
                <input type="date" name="den" value="{{ $den }}">
                <button type="submit" class="btn btn-primary">Lọc dữ liệu</button>
                <a href="{{ route('statistics.index') }}" class="btn btn-outline">Reset</a>
            </form>
        </div>
        
        <div class="card card-pad" style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border: 1px dashed #667eea;">
            <div>
                <h3 style="margin:0; color:#2d3748; font-size: 1.1rem; font-weight: 800;">
                    <i class="fas fa-file-export"></i> XUẤT BÁO CÁO
                </h3>
                <p style="margin:5px 0 0; font-size:12px; color:#718096;">Tải dữ liệu chi tiết từ {{ $tu }} đến {{ $den }}</p>
            </div>
            <div class="action-buttons">
                <a href="{{ route('statistics.export', ['tu' => $tu, 'den' => $den]) }}" class="btn btn-primary" style="background: #27ae60; border: none;">
                    <i class="fas fa-file-excel"></i> Xuất Excel (.xlsx)
                </a>
                <button class="btn btn-outline" onclick="window.print()">
                    <i class="fas fa-print"></i> In báo cáo
                </button>
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div style="flex: 1; background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; padding: 25px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(39,174,96,0.3);">
                <div style="font-size: 14px; opacity: 0.9; font-weight: 800;">TỔNG DOANH THU</div>
                <div style="font-size: 2rem; margin: 10px 0; font-weight: 900;">{{ number_format($revenueData->DoanhThu ?? 0) }} đ</div>
            </div>
            <div style="flex: 1; background: linear-gradient(135deg, #2980b9, #3498db); color: white; padding: 25px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(41,128,185,0.3);">
                <div style="font-size: 14px; opacity: 0.9; font-weight: 800;">ĐƠN HÀNG THÀNH CÔNG</div>
                <div style="font-size: 2rem; margin: 10px 0; font-weight: 900;">{{ $revenueData->SoDon ?? 0 }} đơn</div>
            </div>
        </div>

        <div class="form-grid">
            <div class="card card-pad">
                <h3 style="margin-bottom: 15px; color: #2d3748;"><i class="fas fa-trophy" style="color: #f1c40f;"></i> Top 10 Sách Bán Chạy</h3>
                <div class="table-wrap">
                    <table class="table" style="min-width: 100%;">
                        <thead>
                            <tr>
                                <th>Tên sách</th>
                                <th style="text-align: center;">Đã bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bestSellers as $book)
                            <tr>
                                <td><span style="font-weight: 700;">{{ $book->TenSach }}</span></td>
                                <td style="text-align: center;"><span class="badge badge-green">{{ $book->TongBan }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-pad">
                <h3 style="margin-bottom: 15px; color: #2d3748;"><i class="fas fa-star" style="color: #e67e22;"></i> Khách Hàng Tích Cực</h3>
                <div class="table-wrap">
                    <table class="table" style="min-width: 100%;">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th style="text-align: center;">Số đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topUsers as $user)
                            <tr>
                                <td>
                                    <div style="font-weight: 700;">{{ $user->HoTen }}</div>
                                    <small style="color: #718096;">{{ $user->Email }}</small>
                                </td>
                                <td style="text-align: center;"><span class="badge badge-blue" style="background: #e0e7ff; color: #3730a3;">{{ $user->SoDon }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} Hiên Sách - Hệ thống Báo cáo Kinh doanh
        </div>
    </div>
</div>
@endsection