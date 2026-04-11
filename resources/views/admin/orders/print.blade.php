<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $order->ID }} - Hiên Sách</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333; 
            line-height: 1.6; 
            background: #e9ecef;
            margin: 0;
            padding: 40px 20px;
        }
        
        @media print {
            body { background: #fff; padding: 0; }
            .invoice-paper { padding: 10px !important; box-shadow: none !important; margin: 0; max-width: 100%; border-radius: 0; }
            .no-print { display: none !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }

        .invoice-paper { 
            max-width: 800px; 
            margin: 0 auto; 
            background: #fff;
            padding: 50px; 
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #ff9f43; padding-bottom: 20px; margin-bottom: 30px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .info-box { background: #f8f9fa; padding: 20px 25px; border-radius: 6px; border: 1px solid #eee; }

        /* --- BẢNG HÓA ĐƠN ĐỘC LẬP (KHÔNG DÙNG CLASS .table NỮA) --- */
        .invoice-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            table-layout: fixed; /* Khóa cứng tỷ lệ % của 4 cột */
        }
        
        .invoice-table th, .invoice-table td { 
            padding: 12px 10px; 
            border-bottom: 1px solid #eee; 
            word-wrap: break-word; /* Chữ dài tự rớt dòng, không làm phình bảng */
        }
        
        .invoice-table th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            color: #2d3748; 
            border-top: 1px solid #ddd; 
            border-bottom: 2px solid #ddd; 
        }

        .total-section { display: flex; justify-content: flex-end; margin-top: 20px; }
        .total-table { width: 350px; border-collapse: collapse; }
        .total-table td { padding: 10px 0; }

        .signature-section { display: flex; justify-content: space-between; padding: 0 40px; text-align: center; margin-top: 60px; page-break-inside: avoid; }
        .toolbar { margin-bottom: 30px; display: flex; justify-content: space-between; max-width: 800px; margin-left: auto; margin-right: auto; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; border: none; font-weight: bold; font-size: 14px; }
        .btn-outline { border: 1px solid #ddd; color: #555; background: #fff; }
        .btn-primary { background: #ff9f43; color: #fff; }
    </style>
</head>
<body>
    
    <div class="toolbar no-print">
        <a href="{{ route('admin.orders.show', $order->ID) }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Thực hiện in
        </button>
    </div>

    <div class="invoice-paper">
        <div class="invoice-header">
            <div>
                <h1 style="color: #ff9f43; font-family: 'Playfair Display', serif; margin: 0; font-size: 2.5rem; letter-spacing: 1px;">HIÊN SÁCH</h1>
                <p style="color: #718096; font-size: 14px; margin-top: 5px; text-transform: uppercase; letter-spacing: 2px;">Hóa đơn bán hàng</p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0; color: #2d3748; font-size: 1.5rem;">MÃ ĐƠN: #{{ $order->ID }}</h2>
                <p style="color: #718096; margin-top: 5px; font-size: 14px;">Ngày đặt: {{ date('d/m/Y H:i', strtotime($order->NgayTao ?? $order->NgayDat ?? now())) }}</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <div style="font-weight: 800; margin-bottom: 15px; color: #2d3748; border-bottom: 1px solid #ddd; padding-bottom: 8px;">THÔNG TIN KHÁCH HÀNG</div>
                <p style="margin: 6px 0;"><strong>Khách hàng:</strong> {{ $order->HoTen ?? ($order->user->HoTen ?? 'Khách mua lẻ') }}</p>
                <p style="margin: 6px 0;"><strong>Mã tài khoản:</strong> #{{ $order->IDNguoiDung ?? 'Khách vãng lai' }}</p>
                <p style="margin: 6px 0;"><strong>Trạng thái:</strong> <span style="color: #ff9f43; font-weight: bold;">{{ mb_strtoupper($order->TrangThai, 'UTF-8') }}</span></p>
            </div>
            <div class="info-box" style="text-align: right;">
                <div style="font-weight: 800; margin-bottom: 15px; color: #2d3748; border-bottom: 1px solid #ddd; padding-bottom: 8px;">ĐƠN VỊ BÁN HÀNG</div>
                <p style="margin: 6px 0; font-size: 1.1rem; color: #ff9f43;"><strong>Cửa hàng sách Hiên Sách</strong></p>
                <p style="margin: 6px 0;">Địa chỉ: Sa Đéc, Đồng Tháp</p>
                <p style="margin: 6px 0;">Website: hiensach.com</p>
            </div>
        </div>

        {{-- Đã đổi class thành "invoice-table" để thoát khỏi sự khống chế của admin.css --}}
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="text-align: left; width: 40%;">Tên sản phẩm (Sách)</th>
                    <th style="text-align: center; width: 15%;">Số lượng</th>
                    <th style="text-align: right; width: 20%;">Đơn giá</th>
                    <th style="text-align: right; width: 25%;">Thành tiền</th>
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
                            <div style="font-weight: 700; color: #333;">{{ $item->book->TenSach ?? 'Sách đã bị xóa' }}</div>
                            <small style="color: #a0aec0;">Mã Sách: #{{ $item->IDSach }}</small>
                        </td>
                        <td style="text-align: center; font-weight: 600;">{{ $item->SoLuong }}</td>
                        
                    
                        <td style="text-align: right; color: #4a5568;">{{ number_format($price, 0, ',', '.') }} ₫</td>
                        <td style="text-align: right; font-weight: 700; color: #e53e3e;">
                            {{ number_format($total, 0, ',', '.') }} ₫
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table class="total-table">
                <tr>
                    <td style="color: #718096; text-align: right; padding-right: 20px;">Tạm tính:</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($order->TongTien, 0, ',', '.') }} ₫</td>
                </tr>
                <tr style="border-top: 2px solid #ff9f43;">
                    <td style="font-size: 1.1rem; color: #ff9f43; text-align: right; font-weight: bold; padding-right: 20px; padding-top: 15px;">TỔNG CỘNG:</td>
                    <td style="text-align: right; font-size: 1.3rem; color: #ff9f43; font-weight: bold; padding-top: 15px;">
                        {{ number_format($order->TongTien, 0, ',', '.') }} ₫
                    </td>
                </tr>
            </table>
        </div>

        <div class="signature-section">
            <div>
                <strong style="color: #2d3748; font-size: 1.1rem;">Khách hàng</strong><br>
                <em style="color: #718096; font-size: 13px;">(Ký và ghi rõ họ tên)</em>
                <div style="height: 80px;"></div>
                <p style="font-weight: bold; color: #2d3748;">{{ $order->HoTen ?? ($order->user->HoTen ?? '') }}</p>
            </div>
            <div>
                <strong style="color: #2d3748; font-size: 1.1rem;">Đơn vị bán hàng</strong><br>
                <em style="color: #718096; font-size: 13px;">(Ký, đóng dấu)</em>
                <div style="height: 80px;"></div>
                <p style="font-weight: bold; color: #ff9f43;">HIÊN SÁCH</p>
            </div>
        </div>

        <div style="margin-top: 50px; text-align: center; color: #a0aec0; font-size: 13px; border-top: 1px dashed #eee; padding-top: 20px;">
            <p style="margin: 5px 0;">Cảm ơn quý khách đã mua sắm tại <strong style="color: #ff9f43;">Hiên Sách</strong>!</p>
            <p style="margin: 5px 0;">Hóa đơn này được tạo tự động bởi hệ thống lúc {{ date('H:i d/m/Y') }}.</p>
        </div>

    </div>
</body>
</html>