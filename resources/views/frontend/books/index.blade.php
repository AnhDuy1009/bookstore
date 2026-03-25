@extends('layouts.app')

@section('title', 'Danh mục sách')

@section('content')
<div class="container" style="display: flex; gap: 30px; margin-top: 30px;">
    <aside style="width: 250px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
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
                    <div class="container d-flex justify-content-center mt-5">
                        <div class="small-pagination">
                            {{ $books->links() }} 
                            {{-- Lưu ý: Nếu biến trong Controller là $products thì đổi thành $products->links() --}}
                        </div>
                    </div>
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

    <main style="flex: 1;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @forelse($books as $book)
                <div class="book-card" style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <a href="{{ route('books.show', $book->ID) }}">
                        <img src="{{ $book->Link_Anh_Bia }}" alt="{{ $book->TenSach }}" style="width: 100%; height: 250px; object-fit: cover; border-radius: 4px;">
                        <h4 style="margin: 10px 0; color: #2c3e50;">{{ $book->TenSach }}</h4>
                    </a>
                    <p style="color: #e74c3c; font-weight: bold;">{{ number_format($book->GiaBan) }}đ</p>
                    <a href="{{ route('cart.add', $book->ID) }}" class="btn btn-sm btn-outline-primary">Thêm vào giỏ</a>
                </div>
            @empty
                <p>Không tìm thấy sách nào phù hợp.</p>
            @endforelse
        </div>
        
        <div style="margin-top: 30px;">
            {{ $books->links() }}
        </div>
    </main>
</div>
@endsection