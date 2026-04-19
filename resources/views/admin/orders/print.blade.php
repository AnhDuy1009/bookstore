<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $order->ID }} - Hiên Sách</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="invoice-print">
    
    <div class="invoice-toolbar no-print">
        <a href="{{ route('admin.orders.show', $order->ID) }}" class="invoice-btn invoice-btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <button class="invoice-btn invoice-btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Thực hiện in
        </button>
    </div>

    <div class="invoice-paper">
        <div class="invoice-header">
            <div>
                <h1 class="invoice-brand">HIÊN SÁCH</h1>
                <p class="invoice-type">Hóa đơn bán hàng</p>
            </div>
            <div class="invoice-meta">
                <h2 class="invoice-order-id">MÃ ĐƠN: #{{ $order->ID }}</h2>
                <p class="invoice-date">Ngày đặt: {{ date('d/m/Y H:i', strtotime($order->NgayTao ?? $order->NgayDat ?? now())) }}</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <div class="info-box-title">THÔNG TIN KHÁCH HÀNG</div>
                <p class="info-line"><strong>Khách hàng:</strong> {{ $order->HoTen ?? ($order->user->HoTen ?? 'Khách mua lẻ') }}</p>
                <p class="info-line"><strong>Mã tài khoản:</strong> #{{ $order->IDNguoiDung ?? 'Khách vãng lai' }}</p>
                <p class="info-line"><strong>Trạng thái:</strong> <span class="invoice-text-status">{{ mb_strtoupper($order->TrangThai, 'UTF-8') }}</span></p>
            </div>
            <div class="info-box info-box-right">
                <div class="info-box-title">ĐƠN VỊ BÁN HÀNG</div>
                <p class="info-line invoice-company-name"><strong>Cửa hàng sách Hiên Sách</strong></p>
                <p class="info-line">Địa chỉ: Sa Đéc, Đồng Tháp</p>
                <p class="info-line">Website: hiensach.com</p>
            </div>
        </div>

        {{-- Đã đổi class thành "invoice-table" để thoát khỏi sự khống chế của admin.css --}}
        <table class="invoice-table">
            <thead>
                <tr>
                    <th class="invoice-cell-left invoice-col-product">Tên sản phẩm (Sách)</th>
                    <th class="invoice-cell-center invoice-col-quantity">Số lượng</th>
                    <th class="invoice-cell-right invoice-col-price">Đơn giá</th>
                    <th class="invoice-cell-right invoice-col-total">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $item)
                    @php
                        
                        $price = $item->DonGia ?? $item->GiaBan ?? ($item->book->GiaBan ?? 0);
                        $total = $item->SoLuong * $price;
                    @endphp
                    <tr>
                        <td>
                            <div class="invoice-product-name">{{ $item->book->TenSach ?? 'Sách đã bị xóa' }}</div>
                            <small class="invoice-product-code">Mã Sách: #{{ $item->IDSach }}</small>
                        </td>
                        <td class="invoice-cell-center">{{ $item->SoLuong }}</td>
                        <td class="invoice-cell-right">{{ number_format($price, 0, ',', '.') }} ₫</td>
                        <td class="invoice-cell-right invoice-cell-total">
                            {{ number_format($total, 0, ',', '.') }} ₫
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table class="total-table">
                <tr>
                    <td class="total-label">Tạm tính:</td>
                    <td class="total-amount">{{ number_format($order->TongTien, 0, ',', '.') }} ₫</td>
                </tr>
                <tr class="total-highlight">
                    <td class="total-label">TỔNG CỘNG:</td>
                    <td class="total-amount">
                        {{ number_format($order->TongTien, 0, ',', '.') }} ₫
                    </td>
                </tr>
            </table>
        </div>

        <div class="signature-section">
            <div class="signature-card">
                <strong class="signature-role">Khách hàng</strong><br>
                <em class="signature-note">(Ký và ghi rõ họ tên)</em>
                <div class="signature-space"></div>
                <p class="signature-name">{{ $order->HoTen ?? ($order->user->HoTen ?? '') }}</p>
            </div>
            <div class="signature-card">
                <strong class="signature-role">Đơn vị bán hàng</strong><br>
                <em class="signature-note">(Ký, đóng dấu)</em>
                <div class="signature-space"></div>
                <p class="signature-brand">HIÊN SÁCH</p>
            </div>
        </div>

        <div class="invoice-footer">
            <p class="invoice-footer-text">Cảm ơn quý khách đã mua sắm tại <strong class="invoice-footer-brand">Hiên Sách</strong>!</p>
            <p class="invoice-footer-text">Hóa đơn này được tạo tự động bởi hệ thống lúc {{ date('H:i d/m/Y') }}.</p>
        </div>

    </div>
</body>
</html>