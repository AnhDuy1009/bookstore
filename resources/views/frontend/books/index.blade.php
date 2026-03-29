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
    <aside style="width: 250px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: fit-content;">
        <h3 style="margin-bottom: 20px;">Bộ lọc</h3>
        <form action="{{ route('books.index') }}" method="GET">
            <div style="margin-bottom: 20px;">
                <label><strong>Danh mục</strong></label>
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->ID }}" {{ request('category') == $cat->ID ? 'selected' : '' }}>
                            {{ $cat->TenDanhMuc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label><strong>Giá (VNĐ)</strong></label>
                <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="form-control" style="margin-bottom: 5px;">
                <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Áp dụng</button>
        </form>
    </aside>

    {{-- DANH SÁCH SÁCH --}}
    <main style="flex: 1;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @forelse($books as $book)
                <div class="book-card" style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between;">
                    {{-- Click vào ảnh hoặc tên đều vào trang chi tiết --}}
                    <a href="{{ route('books.show', $book->ID) }}" style="text-decoration: none;">
                        <img src="{{ $book->Link_Anh_Bia }}" alt="{{ $book->TenSach }}" style="width: 100%; height: 250px; object-fit: cover; border-radius: 4px;">
                        <h4 style="margin: 10px 0; color: #2c3e50; font-size: 16px; height: 40px; overflow: hidden;">{{ $book->TenSach }}</h4>
                    </a>
                    
                    <p style="color: #e74c3c; font-weight: bold; margin-bottom: 10px;">{{ number_format($book->GiaBan) }}đ</p>
                    
                    {{-- SỬA LỖI NÚT THÊM GIỎ HÀNG TẠI ĐÂY --}}
                    <form action="{{ route('cart.add', $book->ID) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book->ID }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </form>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p>Không tìm thấy sách nào phù hợp.</p>
                </div>
            @endforelse
        </div>
        
        {{-- PHÂN TRANG --}}
        <div class="pagination-container">
            {{ $books->appends(request()->all())->links("pagination::bootstrap-4") }}
        </div>
    </main>
</div>
@endsection