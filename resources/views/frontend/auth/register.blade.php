@extends('layouts.app') {{-- Hoặc layouts.auth tùy file của bạn --}}

@section('title', 'Đăng ký tài khoản - Hiên Sách')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 40px 0;">
        <div style="width: 100%; max-width: 500px; background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-top: 5px solid #3498db;">
            
            <div style="text-align: center; margin-bottom: 30px;">
                <div class="logo" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
                    <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-book" style="font-size: 28px; color: #3498db;"></i> 
                        <span style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; background: linear-gradient(90deg, #3498db, #2c3e50); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            HIÊN SÁCH
                        </span>
                    </a>
                </div>
                <h2 style="font-family: 'Playfair Display', serif; color: #2c3e50; font-size: 24px; margin-bottom: 8px;">Tạo tài khoản mới</h2>
                <p style="color: #7f8c8d; font-size: 14px;">Gia nhập cộng đồng yêu sách ngay hôm nay</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 5px;">Họ và tên</label>
                    <input type="text" name="name" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                           placeholder="Nguyễn Văn A" value="{{ old('name') }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 5px;">Email</label>
                    <input type="email" name="email" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                           placeholder="example@gmail.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 5px;">Mật khẩu</label>
                    <input type="password" name="password" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                           placeholder="••••••••" required>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 5px;">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" 
                           style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;" 
                           placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-register" style="width: 100%; padding: 12px; border: none; font-size: 16px; font-weight: 600; cursor: pointer;">
                    Đăng ký tài khoản
                </button>
            </form>

            <div style="text-align: center; margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
                <p style="font-size: 14px; color: #7f8c8d;">
                    Đã có tài khoản? 
                    <a href="{{ route('login') }}" style="color: #3498db; text-decoration: none; font-weight: 700;">
                        Đăng nhập tại đây
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection