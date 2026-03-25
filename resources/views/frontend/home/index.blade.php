@extends('layouts.app')

@section('title', 'Trang chủ - Hiên Sách')

@section('content')
<section class="hero">
    <div class="hero-content">
        <h1>Chào mừng bạn đến với Hiên Sách</h1>
        <p>Nơi hội tụ những tác phẩm văn học kinh điển và hiện đại.</p>
        <a href="{{ route('books.index') }}" class="btn-shop">Khám phá ngay</a>
    </div>
</section>

<section class="featured-books container">
    <div class="section-header">
        <h2>Sách Nổi Bật</h2>
        <p>Những cuốn sách được yêu thích nhất thời gian qua</p>
    </div>

    <div class="book-grid">
        @forelse($sach_list as $sach)
            <div class="book-card">
                <div class="book-image">
                    {{-- Sử dụng asset() để trỏ đến thư mục public --}}
                    <img src="{{ asset($sach->Link_Anh_Bia ?? 'assets/images/default-book.jpg') }}" 
                         alt="{{ $sach->Ten_Sach }}">
                </div>
                
                <div class="book-info">
                    <h3 class="book-title">
                        <a href="{{ route('books.show', $sach->ID) }}">{{ $sach->Ten_Sach }}</a>
                    </h3>
                    
                    <div class="info-row">
                        <i class="fas fa-user-edit"></i>
                        <span>{{ $sach->tacGia->TenTacGia ?? 'Đang cập nhật' }}</span>
                    </div>
                    
                    <div class="info-row">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $sach->NamXuatBan ?? '2024' }}</span>
                        <i class="fas fa-file-alt" style="margin-left: 8px;"></i>
                        <span>{{ $sach->SoTrang ?? '0' }} trang</span>
                    </div>
                    
                    <div class="price-row">
                        <span class="price-current">{{ number_format($sach->GiaBan, 0, ',', '.') }}đ</span>
                        {{-- Tính giá cũ giả định như file gốc của bạn (-15%) --}}
                        <span class="price-old">{{ number_format($sach->GiaBan * 1.15, 0, ',', '.') }}đ</span>
                        <span class="price-percent">-15%</span>
                    </div>

                    <div class="book-actions" style="margin-top: 15px;">
                        <form action="{{ route('cart.add', $sach->ID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add-cart" style="width: 100%; padding: 8px; background: #27ae60; color: #white; border: none; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="text-align:center; width:100%;">Không có sách để hiển thị.</p>
        @endforelse
    </div>

    <div class="cta">
        <h2>Sẵn sàng mua sách?</h2>
        <p>Đăng ký ngay để nhận ưu đãi cho đơn hàng đầu tiên</p>
        <a href="{{ route('register') }}">Đăng ký ngay</a>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Bạn có thể thêm CSS đặc thù cho trang chủ ở đây */
    .hero { background: #f8f9fa; padding: 60px 0; text-align: center; margin-bottom: 40px; }
    .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-top: 30px; }
    .book-card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; transition: 0.3s; }
    .book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .book-image img { width: 100%; height: 300px; object-fit: cover; }
    .book-info { padding: 15px; }
    .price-current { color: #e74c3c; font-weight: bold; font-size: 1.2rem; }
    .price-old { text-decoration: line-through; color: #999; margin-left: 10px; font-size: 0.9rem; }
    .cta { background: #2c3e50; color: white; padding: 40px; text-align: center; margin-top: 50px; border-radius: 8px; }
    .cta a { display: inline-block; background: #27ae60; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; margin-top: 15px; }
</style>
@endpush