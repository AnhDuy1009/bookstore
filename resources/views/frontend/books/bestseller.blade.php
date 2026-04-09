@extends('layouts.app')

@section('title', 'Sách Bán Chạy - Hiên Sách')

@section('content')

<style>
    /* CSS Phân trang gọn gàng */
    .pagination-container { margin: 40px 0; display: flex; justify-content: center; }
    .pagination-container ul.pagination { display: flex !important; list-style: none !important; }
    .pagination-container ul.pagination li { margin: 0 5px; }
    .pagination-container ul.pagination li a, .pagination-container ul.pagination li span {
        display: block; padding: 8px 16px; border: 1px solid #ddd; color: #3498db; text-decoration: none; border-radius: 4px;
    }
    .pagination-container ul.pagination li.active span { background: #3498db; color: white; border-color: #3498db; }

    /* Layout 2 cột */
    .main-wrapper { display: flex; gap: 30px; margin-top: 30px; align-items: flex-start; }
    
    /* CSS Card sách (Style Dạy con làm giàu) */
    .book-grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
    .custom-book-card {
        background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: 0.3s; display: flex; flex-direction: column; border: 1px solid #f1f1f1; position: relative;
    }
    .custom-book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
    
    .image-box { position: relative; text-align: center; margin-bottom: 15px; }
    .image-box img { width: 100%; height: 230px; object-fit: contain; }
    .hot-label {
        position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white;
        padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;
    }

    .product-name { font-size: 16px; font-weight: bold; height: 44px; overflow: hidden; margin-bottom: 8px; }
    .product-name a { color: #2c3e50; text-decoration: none; }
    .price-text { color: #e67e22; font-size: 19px; font-weight: 800; margin-bottom: 15px; }
    
    .btn-buy-now {
        width: 100%; padding: 10px; background: #27ae60; color: white; border: none;
        border-radius: 8px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    }
</style>

<div class="container main-wrapper">
    {{-- SIDEBAR BỘ LỌC --}}
    <aside class="filter-sidebar">
    <div class="filter-header">
        <h3><i class="fas fa-filter"></i> Bộ lọc</h3>
    </div>
    
    <form action="{{ route('books.bestseller') }}" method="GET" id="filterForm">
        <div class="filter-group">
            <label class="filter-label">Từ khóa</label>
            <input type="text" name="q" placeholder="Tên sách..." value="{{ request('q') }}" class="form-control-custom">
        </div>

        <div class="filter-group">
            <label class="filter-label">Danh mục</label>
            <div class="category-vertical-list">
                {{-- Nút "Tất cả danh mục" --}}
                <a href="{{ route('books.bestseller', request()->except('category')) }}" 
                   class="category-link {{ !request('category') ? 'active' : '' }}">
                    <i class="fas fa-angle-right"></i> Tất cả danh mục
                </a>

                {{-- Duyệt qua danh sách từ database bookstoredb --}}
                @foreach($categories as $cat)
                    <a href="{{ route('books.bestseller', array_merge(request()->query(), ['category' => $cat->ID])) }}" 
                       class="category-link {{ request('category') == $cat->ID ? 'active' : '' }}">
                        <i class="fas fa-angle-right"></i> {{ $cat->TenDanhMuc }}
                    </a>
                @endforeach
            </div>
            
            {{-- Input ẩn để giữ giá trị category khi nhấn nút "Áp dụng" giá --}}
            <input type="hidden" name="category" value="{{ request('category') }}">
        </div>

        <div class="filter-group">
            <label class="filter-label">Khoảng giá (VNĐ)</label>
            <div class="price-inputs">
                <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}">
                <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}">
            </div>
        </div>

        <button type="submit" class="btn-filter-apply">Áp dụng</button>
        
        @if(request()->anyFilled(['q', 'category', 'min_price', 'max_price']))
            <a href="{{ route('books.bestseller') }}" class="btn-clear">
                <i class="fas fa-times"></i> Xóa tất cả bộ lọc
            </a>
        @endif
    </form>
</aside>

    {{-- HIỂN THỊ DANH SÁCH --}}
    <main style="flex: 1;">
        <h2 style="margin-bottom: 25px;">🔥 Sách Bán Chạy </h2>
        
        <div class="book-grid-container">
            @forelse($books as $book)
                <div class="custom-book-card">
                    <div class="image-box">
                        <span class="hot-label">HOT</span>
                        <a href="{{ route('books.show', $book->ID) }}">
                            <img src="{{ Str::startsWith($book->Link_image, ['http://', 'https://']) 
            ? $book->Link_image 
            : asset('storage/' . $book->Link_image) }}" 
     alt="{{ $book->TenSach }};" >
    
                        </a>
                    </div>

                    <div class="info-box">
                        <h4 class="product-name">
                            <a href="{{ route('books.show', $book->ID) }}">{{ $book->TenSach }}</a>
                        </h4>
                        <p style="font-size: 13px; color: #7f8c8d; margin-bottom: 10px;">
                            <i class="fas fa-eye"></i> {{ number_format($book->LuotXem) }} lượt xem
                        </p>
                        <p class="price-text">{{ number_format($book->GiaBan) }}đ</p>
                        
                        <form action="{{ route('cart.add', $book->ID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-buy-now">
                                <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p>Không có sách nào đạt mốc bán chạy phù hợp với tiêu chí lọc.</p>
            @endforelse
        </div>

        <div class="pagination-container">
            {{ $books->appends(request()->all())->links("pagination::bootstrap-4") }}
        </div>
    </main>
</div>
@endsection