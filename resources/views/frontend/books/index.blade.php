@extends('layouts.app')

@section('title', 'Danh mục sách')

@section('content')

<style>
    /* Thu nhỏ mũi tên phân trang */
    .pagination svg {
        width: 20px !important;
        height: 20px !important;
    }
    /* Ẩn dòng chữ Showing... dư thừa */
    .pagination .flex.justify-between.flex-1 {
        display: none !important;
    }
    .pagination .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
        display: flex !important;
    }
    /* Fix tiêu đề sách không bị nhảy hàng/che khuất */
    .book-card h4 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        text-overflow: ellipsis;
        height: 40px !important;
        line-height: 20px !important;
        margin: 10px 0 !important;
    }

    /* Container bao quanh phân trang */
.pagination-container {
    margin: 40px 0;
    display: flex;
    justify-content: center;
}

/* Ép danh sách số trang dàn hàng ngang */
.pagination-container ul.pagination {
    display: flex !important;
    list-style: none !important;
    padding-left: 0 !important;
}

/* Định dạng từng ô số */
.pagination-container ul.pagination li {
    margin: 0 5px;
}

.pagination-container ul.pagination li a, 
.pagination-container ul.pagination li span {
    display: block;
    padding: 8px 16px;
    border: 1px solid #ddd;
    color: #3498db;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s;
}

/* Hiệu ứng khi di chuột vào hoặc trang đang chọn */
.pagination-container ul.pagination li.active span,
.pagination-container ul.pagination li a:hover {
    background-color: #3498db;
    color: white;
    border-color: #3498db;
}

/* Thu nhỏ mũi tên nếu nó còn hiện to */
.pagination-container svg {
    width: 20px !important;
    height: 20px !important;
}
</style>

<div class="container" style="display: flex; gap: 30px; margin-top: 30px;">
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
    <main style="flex: 1;">
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
                <img src="{{ asset('assets/images/no-book.png') }}" style="width: 100px; opacity: 0.5;">
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