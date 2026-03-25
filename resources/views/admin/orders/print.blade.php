<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $order->ID }} - Hiên Sách</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Tối ưu hóa cho việc in ấn */
        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .admin-container { box-shadow: none; border: none; max-width: 100%; margin: 0; }
            .card { border: 1px solid #eee; box-shadow: none; }
        }
        .invoice-box { padding: 40px; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 30px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .total-section { display: flex; justify-content: flex-end; margin-top: 30px; }
        .total-table { width: 300px; }
        .total-table td { padding: 10px; font-weight: 800; }
    </style>
</head>
<body>
    <div class="wrap" style="max-width: 900px; margin: 20px auto;">
        <div class="toolbar no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between;">
            <a href="{{ route('orders.show', $order->ID) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Quay lại chi tiết
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Thực hiện in
            </button>
        </div>

        <div class="admin-container card">
            <div class="invoice-box">
                <div class="invoice-header">
                    <div>
                        <h1 style="color: #667eea; font-family: 'Playfair Display', serif;">HIÊN SÁCH</h1>
                        <p style="color: #718096; font-size: 14px;">Hóa đơn bán hàng điện tử</p>
                    </div>
                    <div style="text-align: right;">
                        <h2 style="margin: 0;">MÃ ĐƠN: #{{ $order->ID }}</h2>
                        <p style="color: #718096;">Ngày đặt: {{ $order->NgayTao }}</p>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="card card-pad" style="background: #f8f9fa;">
                        <div style="font-weight: 800; margin-bottom: 10px; color: #2d3748;">THÔNG TIN KHÁCH HÀNG</div>
                        <p>ID Người dùng: #{{ $order->IDNguoiDung }}</p>
                        <p>Trạng thái đơn: <strong>{{ $order->TrangThai }}</strong></p>
                    </div>
                    <div class="card card-pad" style="background: #f8f9fa; text-align: right;">
                        <div style="font-weight: 800; margin-bottom: 10px; color: #2d3748;">ĐƠN VỊ BÁN HÀNG</div>
                        <p><strong>Cửa hàng sách Hiên Sách</strong></p>
                        <p>Địa chỉ: Sa Đéc, Đồng Tháp</p>
                        <p>Website: hiensach.com</p>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="table" style="min-width: 100%;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th>Tên sản phẩm (Sách)</th>
                                <th style="text-align: center;">Số lượng</th>
                                <th style="text-align: right;">Đơn giá</th>
                                <th style="text-align: right;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $item)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700;">{{ $item->book->TenSach ?? 'Sách đã xóa' }}</div>
                                        <small style="color: #a0aec0;">ID: #{{ $item->IDSach }}</small>
                                    </td>
                                    <td style="text-align: center;">{{ $item->SoLuong }}</td>
                                    <td style="text-align: right;">{{ number_format($item->DonGia, 0, ',', '.') }} đ</td>
                                    <td style="text-align: right; font-weight: 700;">
                                        {{ number_format($item->SoLuong * $item->DonGia, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="total-section">
                    <table class="total-table">
                        <tr>
                            <td style="color: #718096;">Tạm tính:</td>
                            <td style="text-align: right;">{{ number_format($order->TongTien, 0, ',', '.') }} đ</td>
                        </tr>
                        <tr style="border-top: 2px solid #667eea;">
                            <td style="font-size: 1.2rem; color: #667eea;">TỔNG CỘNG:</td>
                            <td style="text-align: right; font-size: 1.2rem; color: #667eea;">
                                {{ number_format($order->TongTien, 0, ',', '.') }} đ
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="margin-top: 50px; text-align: center; color: #cbd5e1; font-size: 12px;">
                    <p>Cảm ơn quý khách đã mua sắm tại Hiên Sách!</p>
                    <p>Hóa đơn này được tạo tự động bởi hệ thống quản trị.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>