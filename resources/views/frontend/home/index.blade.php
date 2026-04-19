@extends('layouts.app')

@section('title', 'Trang chủ - Hiên Sách')

@section('content')
{{-- SECTION: HERO --}}
<section class="hero">
    <div class="hero-content">
        <div class="banner">
        <h1>Chào mừng bạn đến với Hiên Sách</h1>
        <p>Nơi hội tụ những tác phẩm văn học kinh điển và hiện đại.</p>
        <a href="{{ route('books.index') }}" class="btn-shop">Khám phá ngay</a>
    </div>
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

