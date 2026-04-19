@extends('layouts.app')

@section('title', 'Danh mục sách')

@section('content')

<div class="container main-wrapper">
    {{-- SIDEBAR BỘ LỌC --}}
    <aside class="filter-sidebar">
    <div class="filter-header">
        <h3><i class="fas fa-filter"></i> Bộ lọc</h3>
    </div>
    
    <form action="{{ route('books.index') }}" method="GET" id="filterForm">
        <div class="filter-group">
            <label class="filter-label">Từ khóa</label>
            <input type="text" name="q" placeholder="Tên sách..." value="{{ request('q') }}" class="form-control-custom">
        </div>

        <div class="filter-group">
            <label class="filter-label">Danh mục</label>
            <div class="category-vertical-list">
                {{-- Nút "Tất cả danh mục" --}}
                <a href="{{ route('books.index', request()->except('category')) }}" 
                   class="category-link {{ !request('category') ? 'active' : '' }}">
                    <i class="fas fa-angle-right"></i> Tất cả danh mục
                </a>

                {{-- Duyệt qua danh sách từ database bookstoredb --}}
                @foreach($categories as $cat)
                    <a href="{{ route('books.index', array_merge(request()->query(), ['category' => $cat->ID])) }}" 
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
            <a href="{{ route('books.index') }}" class="btn-clear">
                <i class="fas fa-times"></i> Xóa tất cả bộ lọc
            </a>
        @endif
    </form>
</aside>
    {{-- DANH SÁCH SÁCH --}}
    <main class="book-content">
        <div class="category-page-wrapper">
    <div class="book-grid-container">
        @forelse($books as $book)
            <div class="custom-book-card">
                {{-- Phần ảnh sách --}}
                <div class="image-box">
                    @if(isset($book->LuotXem) && $book->LuotXem > 10000)
                        <span class="hot-label">HOT</span>
                    @endif
                    <a href="{{ route('books.show', $book->ID) }}">
                        <img src="{{ Str::startsWith($book->Link_image, ['http://', 'https://']) 
            ? $book->Link_image 
            : asset('storage/' . $book->Link_image) }}" 
     alt="{{ $book->TenSach }};" >
                    </a>
                </div>

                {{-- Thông tin sách --}}
                <div class="info-box">
                    <h4 class="product-name">
                        <a href="{{ route('books.show', $book->ID) }}">{{ $book->TenSach }}</a>
                    </h4>
                    
                    {{-- Bổ sung tên tác giả cho giống mẫu --}}
                    <p class="author-text">
                        <i class="fas fa-user-edit"></i> {{ $book->tacGia->TenTacGia ?? 'Khuyết danh' }}
                    </p>

                    <p class="price-text">{{ number_format($book->GiaBan) }}đ</p>
                    
                    {{-- Form thêm giỏ hàng --}}
                    <form action="{{ route('cart.add', $book->ID) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book->ID }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buy-now">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="no-results">
                <img src="{{ asset('assets/images/no-book.png') }}" alt="Không tìm thấy sách phù hợp">
                <p>Không tìm thấy sách nào phù hợp với bộ lọc.</p>
            </div>
        @endforelse
    </div>
</div>
        
        {{-- PHÂN TRANG --}}
        <div class="pagination-container">
            {{ $books->appends(request()->all())->links("pagination::bootstrap-4") }}
        </div>
    </main>
</div>
@endsection