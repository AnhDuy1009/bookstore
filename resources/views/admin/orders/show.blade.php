@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->ID)

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>CHI TIẾT ĐƠN HÀNG</h1>
        <p class="welcome">Thông tin chi tiết đơn #{{ $order->ID }}</p>
    </div>

    <div class="admin-content">
        <div class="toolbar">
            <div></div>
            <div class="action-buttons">
                <a class="btn btn-outline" href="{{ route('orders.index') }}">← Quay lại</a>
                <a class="btn btn-outline" href="{{ route('orders.print', $order->ID) }}" target="_blank">🖨 In hóa đơn</a>
            </div>
        </div>

        <div class="card card-pad" style="display: flex; gap: 25px; flex-wrap: wrap; margin-bottom: 20px;">
            <div style="flex: 1; min-width: 200px;">
                <div style="font-weight: 800; color: #718096; font-size: 12px; margin-bottom: 5px;">KHÁCH HÀNG</div>
                <div style="font-weight: 700; color: #2d3748;">ID Người dùng: #{{ $order->IDNguoiDung }}</div>
                <div style="font-size: 14px; color: #4a5568;">Ngày đặt: {{ $order->NgayTao }}</div>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <div style="font-weight: 800; color: #718096; font-size: 12px; margin-bottom: 5px;">THANH TOÁN</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #667eea;">
                    {{ number_format($order->TongTien, 0, ',', '.') }} đ
                </div>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <div style="font-weight: 800; color: #718096; font-size: 12px; margin-bottom: 5px;">TRẠNG THÁI</div>
                <span class="badge badge-gray" style="font-size: 14px; padding: 6px 15px;">{{ $order->TrangThai }}</span>
            </div>
        </div>

        <div class="form-card" style="margin-bottom: 25px;">
            <div style="font-weight: 800; margin-bottom: 15px; color: #2d3748;">Cập nhật trạng thái đơn hàng</div>
            <form action="{{ route('orders.updateStatus', $order->ID) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-grid">
                    <div class="form-group">
                        <label>Chọn trạng thái mới</label>
                        <select name="status" required>
                            <option value="NEW" {{ $order->TrangThai == 'NEW' ? 'selected' : '' }}>Mới (NEW)</option>
                            <option value="PAID" {{ $order->TrangThai == 'PAID' ? 'selected' : '' }}>Đã thanh toán (PAID)</option>
                            <option value="SHIPPING" {{ $order->TrangThai == 'SHIPPING' ? 'selected' : '' }}>Đang giao (SHIPPING)</option>
                            <option value="DONE" {{ $order->TrangThai == 'DONE' ? 'selected' : '' }}>Hoàn thành (DONE)</option>
                            <option value="CANCEL" {{ $order->TrangThai == 'CANCEL' ? 'selected' : '' }}>Hủy đơn (CANCEL)</option>
                        </select>
                    </div>
                    <div class="form-actions" style="margin-top: 0; align-self: flex-end;">
                        <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <div style="padding: 15px 20px; font-weight: 800; background: #f8f9fa; border-bottom: 1px solid #eee;">
                DANH SÁCH SẢN PHẨM
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sách</th>
                        <th style="width: 120px;">Số lượng</th>
                        <th style="width: 160px;">Đơn giá</th>
                        <th style="width: 160px;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $item)
                        <tr>
                            <td>
                                <div style="font-weight: 700;">{{ $item->book->TenSach ?? 'Sách đã xóa' }}</div>
                                <small class="muted">ID Sách: #{{ $item->IDSach }}</small>
                            </td>
                            <td>{{ $item->SoLuong }}</td>
                            <td>{{ number_format($item->DonGia, 0, ',', '.') }} đ</td>
                            <td style="font-weight: 700;">
                                {{ number_format($item->SoLuong * $item->DonGia, 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            Hiên Sách Admin System &copy; {{ date('Y') }}
        </div>
    </div>
</div>
@endsection