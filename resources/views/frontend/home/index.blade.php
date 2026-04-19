@extends('layouts.app')

@section('title', 'Trang chủ - Hiên Sách')

@section('content')
{{-- SECTION: HERO --}}
<section class="hero">
    <div class="hero-content">
        <h1>Chào mừng bạn đến với Hiên Sách</h1>
        <p>Nơi hội tụ những tác phẩm văn học kinh điển và hiện đại.</p>
        <a href="{{ route('books.index') }}" class="btn-shop">Khám phá ngay</a>
    </div>
</section>

{{-- SECTION: SÁCH BÁN CHẠY (Featured) --}}
<section class="featured-books container">
    <div class="section-header">
        <h2>Sách Bán Chạy</h2>
        <p>Những cuốn sách được yêu thích nhất thời gian qua</p>
    </div>

    <div class="book-grid">
        @forelse($book_ban_chay as $book)
            <div class="book-card">
                <div class="book-image">
                    <a href="{{ route('books.show', $book->ID) }}">
                        <img src="{{ Str::startsWith($book->Link_image, ['http://', 'https://']) 
            ? $book->Link_image 
            : asset('storage/' . $book->Link_image) }}" 
     alt="{{ $book->TenSach }};" >
                    </a>
                    @if($book->LuotXem > 100)
                        <span class="badge-hot">HOT</span>
                    @endif
                </div>
                
                <div class="book-info">
                    <h3 class="book-title">
                        <a href="{{ route('books.show', $book->ID) }}">{{ $book->TenSach }}</a>
                    </h3>
                    
                    <div class="info-row">
                        <i class="fas fa-user-edit"></i>
                        <span>{{ $book->tacGia->TenTacGia ?? 'Khuyết danh' }}</span>
                    </div>
                    
                    <div class="price-row">
                        <span class="price-current">{{ number_format($book->GiaBan) }}đ</span>
                    
                    </div>

                    <div class="book-actions">
                        <form action="{{ route('cart.add', $book->ID) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        @empty
            <p style="text-align:center; width:100%;">Hiện chưa có sách bán chạy.</p>
        @endforelse
    </div>
</section>

{{-- SECTION: SÁCH MỚI NHẤT (New Arrivals) --}}
<section class="featured-books container" style="margin-top: 50px;">
    <div class="section-header">
        <h2>Sách Mới Nhất</h2>
        <p>Những tác phẩm vừa cập bến Hiên Sách</p>
    </div>

    <div class="book-grid">
        @forelse($book_moi as $book)
            <div class="book-card">
                <div class="book-image">
                    <a href="{{ route('books.show', $book->ID) }}">
                        <img src="{{ Str::startsWith($book->Link_image, ['http://', 'https://']) 
            ? $book->Link_image 
            : asset('storage/' . $book->Link_image) }}" 
     alt="{{ $book->TenSach }};" >
                    </a>
                </div>
                
                <div class="book-info">
                    <h3 class="book-title">
                        <a href="{{ route('books.show', $book->ID) }}">{{ $book->TenSach }}</a>
                    </h3>
                    
                    <div class="info-row">
                        <i class="fas fa-user-edit"></i>
                        <span>{{ $book->tacGia->TenTacGia ?? 'Khuyết danh' }}</span>
                    </div>
                    
                    <div class="price-row">
                        <span class="price-current">{{ number_format($book->GiaBan) }}đ</span>
                    </div>

                    <div class="book-actions">
                        <form action="{{ route('cart.add', $book->ID) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p style="text-align:center; width:100%;">Hiện chưa có sách mới.</p>
        @endforelse
    </div>
</section>

{{-- SECTION: CTA --}}
<section class="container">
    <div class="cta">
        <h2>Sẵn sàng mua sách?</h2>
        <p>Đăng ký ngay để nhận ưu đãi cho đơn hàng đầu tiên</p>
        <a href="{{ route('register') }}">Đăng ký ngay</a>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Tổng thể & Hero */
    .hero { background: #f8f9fa; padding: 60px 0; text-align: center; margin-bottom: 40px; }
    .hero h1 { color: #2c3e50; font-weight: bold; }
    .btn-shop { display: inline-block; background: #3498db; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; margin-top: 15px; }

    /* Lưới sách */
    .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-top: 30px; }
    
    /* Thẻ sách */
    .book-card { background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s; position: relative; }
    .book-card:hover { transform: translateY(-5px); }
    
    .book-image { position: relative; overflow: hidden; }
    .book-image img { width: 100%; height: 300px; object-fit: cover; border-radius: 5px; }
    
    .badge-hot { position: absolute; top: 10px; right: 10px; background: #e74c3c; color: white; padding: 2px 8px; border-radius: 20px; font-size: 12px; font-weight: bold; }

    .book-info { padding: 10px 0; }
    .book-title { margin: 10px 0 5px; font-size: 16px; height: 40px; overflow: hidden; line-height: 1.3; }
    .book-title a { text-decoration: none; color: #2c3e50; }
    
    .info-row { color: #7f8c8d; font-size: 13px; margin-bottom: 8px; }
    
    .price-row { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
    .price-current { color: #e67e22; font-weight: bold; font-size: 18px; }
    .price-old { color: #95a5a6; text-decoration: line-through; font-size: 13px; }

    /* Nút bấm */
    .book-actions { display: flex; gap: 5px; }
    .btn-add-cart { width: 100%; padding: 8px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s; }
    .btn-add-cart:hover { background: #219150; }
    .btn-wishlist { padding: 8px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; }

    /* CTA */
    .cta { background: #2c3e50; color: white; padding: 40px; text-align: center; margin-top: 50px; border-radius: 10px; }
    .cta a { display: inline-block; background: #27ae60; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; margin-top: 15px; font-weight: bold; }
</style>
@endpush