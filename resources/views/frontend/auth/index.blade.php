@extends('layouts.app')
@section('title', 'Tài khoản')

@section('content')
<div class="container" style="padding: 60px 0;">
    <div class="auth-portal-wrapper" style="max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: center;">
        
        <div class="auth-info" style="padding: 20px;">
            <h1 style="color: #2c3e50; font-size: 32px; margin-bottom: 20px;">Chào mừng bạn đến với <span style="color: #3498db;">Hiên Sách</span></h1>
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">Đăng nhập để trải nghiệm đầy đủ các tính năng dành riêng cho thành viên:</p>
            
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #2ecc71; margin-right: 10px;"></i> Theo dõi trạng thái đơn hàng dễ dàng</li>
                <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #2ecc71; margin-right: 10px;"></i> Lưu cuốn sách yêu thích vào Wishlist</li>
                <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #2ecc71; margin-right: 10px;"></i> Nhận thông báo về các chương trình giảm giá</li>
                <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #2ecc71; margin-right: 10px;"></i> Tích điểm đổi quà cho mỗi lần mua sắm</li>
            </ul>
        </div>

        <div class="auth-actions" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center;">
            <div style="margin-bottom: 30px;">
                <i class="fas fa-user-circle" style="font-size: 60px; color: #d0d7de;"></i>
            </div>
            
            <h3 style="margin-bottom: 25px; color: #2c3e50;">Bạn đã có tài khoản chưa?</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <a href="{{ route('login') }}" class="btn-login" style="display: block; padding: 15px; background: #3498db; color: #fff; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 18px; transition: 0.3s;">
                    <i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP NGAY
                </a>
                
                <div style="display: flex; align-items: center; margin: 10px 0;">
                    <hr style="flex: 1; border: 0; border-top: 1px solid #eee;">
                    <span style="padding: 0 15px; color: #bbb; font-size: 14px;">HOẶC</span>
                    <hr style="flex: 1; border: 0; border-top: 1px solid #eee;">
                </div>

                <a href="{{ route('register') }}" class="btn-register" style="display: block; padding: 15px; border: 2px solid #2ecc71; color: #2ecc71; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 18px; transition: 0.3s;">
                    <i class="fas fa-user-plus"></i> ĐĂNG KÝ TÀI KHOẢN
                </a>
            </div>

            <p style="margin-top: 25px; font-size: 14px;">
                <a href="{{ route('home') }}" style="color: #7f8c8d; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Quay lại trang chủ
                </a>
            </p>
        </div>
    </div>
</div>

<style>
    /* Hiệu ứng hover cho các nút */
    .btn-login:hover {
        background: #2980b9 !important;
        transform: translateY(-2px);
    }
    .btn-register:hover {
        background: #2ecc71 !important;
        color: #fff !important;
        transform: translateY(-2px);
    }
    
    /* Responsive cho Mobile */
    @media (max-width: 768px) {
        .auth-portal-wrapper {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        .auth-info {
            text-align: center;
        }
    }
</style>
@endsection