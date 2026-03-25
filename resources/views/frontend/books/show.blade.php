@extends('layouts.app')

@section('title', $book->TenSach)

@section('content')
<div class="container" style="padding: 40px 0;">
    <div style="background: #fff; padding: 30px; border-radius: 15px; display: flex; gap: 50px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 350px;">
            <img src="{{ $book->Link_Anh_Bia }}" style="width: 100%; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>

        <div style="flex: 1.5; min-width: 350px;">
            <nav style="color: #7f8c8d; margin-bottom: 10px;">
                Trang chủ / {{ $book->danhMuc->TenDanhMuc }} / {{ $book->TenSach }}
            </nav>
            <h1 style="font-size: 32px; margin-bottom: 10px;">{{ $book->TenSach }}</h1>
            
            <div style="margin-bottom: 20px;">
                Tác giả: <a href="{{ route('authors.show', $book->IDTacGia) }}" style="color: #3498db; font-weight: bold;">{{ $book->tacGia->TenTacGia }}</a>
                <span style="margin: 0 15px; color: #ddd;">|</span>
                Lượt xem: <strong>{{ $book->LuotXem }}</strong>
            </div>

            <div style="background: #fdf2e9; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                <span style="font-size: 30px; color: #e67e22; font-weight: bold;">{{ number_format($book->GiaBan) }}đ</span>
                <span style="text-decoration: line-through; margin-left: 15px; color: #95a5a6;">{{ number_format($book->GiaBan * 1.2) }}đ</span>
            </div>

            <div style="margin-bottom: 30px;">
                <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Mô tả nội dung</h4>
                <p style="line-height: 1.8; color: #555; margin-top: 15px;">{{ $book->MoTa }}</p>
            </div>

            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                @csrf
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 5px;">
                        <button type="button" style="padding: 10px 15px; border: none; background: none;">-</button>
                        <input type="number" name="quantity" value="1" style="width: 50px; text-align: center; border: none;">
                        <button type="button" style="padding: 10px 15px; border: none; background: none;">+</button>
                    </div>
                    <button type="submit" style="flex-grow: 1; background: #e74c3c; color: white; border: none; padding: 15px; border-radius: 5px; font-weight: bold; font-size: 18px; cursor: pointer;">
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="margin-top: 60px;">
        <h3 style="margin-bottom: 30px; position: relative; padding-left: 15px;">
            <span style="position: absolute; left: 0; top: 0; bottom: 0; width: 5px; background: #3498db;"></span>
            Sách cùng thể loại
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @foreach($relatedBooks as $relBook)
                @include('frontend.books.partials.book_item', ['book' => $relBook])
            @endforeach
        </div>
    </div>
</div>
@endsection