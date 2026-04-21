<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xac nhan don hang</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px; width:100%; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background:#0f766e; color:#ffffff; padding:20px 24px;">
                            <h1 style="margin:0; font-size:22px;">Xac nhan dat hang thanh cong</h1>
                            <p style="margin:8px 0 0; font-size:14px; opacity:.95;">Cam on ban da mua hang tai BookStore.</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 14px; font-size:15px;">Xin chao {{ $order->user->HoTen ?? 'Quy khach' }},</p>
                            <p style="margin:0 0 8px; font-size:14px;">Don hang <strong>{{ $order->MaDonHang }}</strong> cua ban da duoc tiep nhan.</p>
                            <p style="margin:0 0 8px; font-size:14px;">Ngay dat: <strong>{{ optional($order->NgayDat)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</strong></p>
                            <p style="margin:0 0 8px; font-size:14px;">Phuong thuc thanh toan: <strong>{{ strtoupper($order->PhuongThucThanhToan ?? 'COD') }}</strong></p>
                            <p style="margin:0 0 20px; font-size:14px;">Trang thai: <strong>{{ $order->TrangThai }}</strong></p>

                            <h2 style="margin:0 0 12px; font-size:16px; color:#111827;">Chi tiet don hang</h2>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border:1px solid #e5e7eb;">
                                <thead>
                                    <tr style="background:#f9fafb;">
                                        <th align="left" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">San pham</th>
                                        <th align="center" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">So luong</th>
                                        <th align="right" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">Don gia</th>
                                        <th align="right" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">Thanh tien</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach($order->items as $item)
                                        @php
                                            $lineTotal = ($item->SoLuong ?? 0) * ($item->GiaBan ?? 0);
                                            $subtotal += $lineTotal;
                                        @endphp
                                        <tr>
                                            <td style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">{{ $item->book->TenSach ?? 'San pham' }}</td>
                                            <td align="center" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">{{ $item->SoLuong }}</td>
                                            <td align="right" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">{{ number_format($item->GiaBan, 0, ',', '.') }} VND</td>
                                            <td align="right" style="padding:10px; border-bottom:1px solid #e5e7eb; font-size:13px;">{{ number_format($lineTotal, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-top:12px; border-collapse:collapse;">
                                <tr>
                                    <td style="padding:4px 0; font-size:14px;">Tam tinh:</td>
                                    <td align="right" style="padding:4px 0; font-size:14px;">{{ number_format($subtotal, 0, ',', '.') }} VND</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 0; font-size:14px;">Phi van chuyen:</td>
                                    <td align="right" style="padding:4px 0; font-size:14px;">{{ number_format($order->PhiShip ?? 0, 0, ',', '.') }} VND</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0; font-size:15px;"><strong>Tong thanh toan:</strong></td>
                                    <td align="right" style="padding:6px 0; font-size:15px;"><strong>{{ number_format($order->TongTien, 0, ',', '.') }} VND</strong></td>
                                </tr>
                            </table>

                            <p style="margin:18px 0 0; font-size:13px; color:#4b5563;">Dia chi giao hang: {{ $order->DiaChiGiaoHang }}</p>
                            <p style="margin:6px 0 0; font-size:13px; color:#4b5563;">So dien thoai nhan hang: {{ $order->SoDienThoai }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 24px; background:#f9fafb; color:#6b7280; font-size:12px;">
                            Email nay duoc gui tu he thong BookStore. Vui long khong tra loi email tu dong nay.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
