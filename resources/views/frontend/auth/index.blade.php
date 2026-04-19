@extends('layouts.app')
@section('title', 'Tài khoản')

@section('content')
<div class="container auth-page">
    <div class="auth-portal-wrapper">
        <div class="auth-info">
            <h1>Chào mừng bạn đến với <span>Hiên Sách</span></h1>
            <p>Đăng nhập để trải nghiệm đầy đủ các tính năng dành riêng cho thành viên:</p>
            <ul>
                <li><i class="fas fa-check-circle"></i> Theo dõi trạng thái đơn hàng dễ dàng</li>
                <li><i class="fas fa-check-circle"></i> Lưu cuốn sách yêu thích vào Wishlist</li>
                <li><i class="fas fa-check-circle"></i> Nhận thông báo về các chương trình giảm giá</li>
                <li><i class="fas fa-check-circle"></i> Tích điểm đổi quà cho mỗi lần mua sắm</li>
            </ul>
        </div>

        <div class="auth-actions">
            <div class="auth-actions-icon">
                <i class="fas fa-user-circle"></i>
            </div>

            <h3>Bạn đã có tài khoản chưa?</h3>

            <div class="auth-action-buttons">
                <a href="{{ route('login') }}" class="btn-login auth-cta-link auth-cta-login">
                    <i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP NGAY
                </a>

                <div class="auth-action-divider">
                    <hr>
                    <span>HOẶC</span>
                    <hr>
                </div>

                <a href="{{ route('register') }}" class="btn-register auth-cta-link auth-cta-register">
                    <i class="fas fa-user-plus"></i> ĐĂNG KÝ TÀI KHOẢN
                </a>
            </div>

            <p class="auth-return-text">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
            </p>
        </div>
    </div>
</div>
@endsection