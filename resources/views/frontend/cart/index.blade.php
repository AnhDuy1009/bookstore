@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container" style="padding: 40px 0;">
    <h1 style="margin-bottom: 30px; color: #2c3e50;"><i class="fas fa-shopping-cart"></i> Giỏ hàng</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <a href="{{ route('cart.clear') }}" 
           class="btn btn-outline-danger btn-sm" 
           style="margin-bottom: 20px; display: inline-block;"
           onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?')">
           <i class="fas fa-trash-alt"></i> Xóa tất cả
        </a>
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            
            <div style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #eee; text-align: left;">
                            <th style="padding: 15px;">Sản phẩm</th>
                            <th style="padding: 15px;">Giá</th>
                            <th style="padding: 15px;">Số lượng</th>
                            <th style="padding: 15px;">Tổng</th>
                            <th style="padding: 15px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                                    <img src="{{ $details['image'] ?? '' }}" style="width: 70px; border-radius: 8px;" alt="Bìa sách">
                                    <span style="font-weight: bold;">{{ $details['title'] ?? 'Tên sách' }}</span>
                                </td>
                                <td style="padding: 15px;">{{ number_format($details['price']) }}đ</td>
                                <td style="padding: 15px;">
                                    <form action="{{ route('cart.update') }}" method="POST" style="display: flex; align-items: center; gap: 5px;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
        
                                        {{-- Đã thêm sự kiện onchange tự động submit form --}}
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                            style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 5px;"
                                            onchange="this.form.submit()">
            
                                        {{-- Nút cập nhật đã được xóa bỏ để UI gọn gàng hơn --}}
                                    </form>
                                </td>
                                <td style="padding: 15px; font-weight: bold; color: #e74c3c;">
                                    {{ number_format($details['price'] * $details['quantity']) }}đ
                                </td>
                                <td style="padding: 15px;">
                                    <a href="{{ route('cart.remove', $id) }}" style="color: #95a5a6;" title="Xóa" onclick="return confirm('Xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); height: fit-content;">
                <h3 style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Thanh toán</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($total) }}đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span>Phí vận chuyển:</span>
                    <span>30,000đ</span>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 20px; font-weight: bold;">
                    <span>Tổng cộng:</span>
                    <span style="color: #e74c3c;">{{ number_format($total + 30000) }}đ</span>
                </div>
                
                <a href="{{ route('order.checkout') ?? '#' }}" 
                style="display: block; background: #27ae60; color: #fff; text-align: center; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s;">
                    TIẾN HÀNH ĐẶT HÀNG
                </a>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 100px 0;">
            <i class="fas fa-shopping-basket" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
            <p style="color: #7f8c8d; font-size: 18px;">Giỏ hàng của bạn đang trống!</p>
            <a href="{{ route('books.index') ?? '#' }}" style="color: #3498db; text-decoration: none; font-weight: bold;">Tiếp tục mua sắm</a>
        </div>
    @endif
</div>
@endsection