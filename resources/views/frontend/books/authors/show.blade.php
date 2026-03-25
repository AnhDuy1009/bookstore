@extends('layouts.app')

@section('title', 'Tác giả: ' . $author->TenTacGia)

@section('content')
<div class="container" style="padding: 40px 0;">
    <div style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; gap: 50px; flex-wrap: wrap; margin-bottom: 50px;">
        <div style="flex: 1; min-width: 250px; text-align: center;">
            <img src="{{ $author->Link_Chan_Dung }}" 
                 alt="{{ $author->TenTacGia }}" 
                 style="width: 250px; height: 250px; border-radius: 20px; object-fit: cover; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            
            <div style="margin-top: 20px;">
                <button class="btn-follow" style="background: #3498db; color: white; border: none; padding: 10px 30px; border-radius: 25px; font-weight: bold; cursor: pointer;">
                    <i class="fas fa-plus"></i> Theo dõi tác giả
                </button>
            </div>
        </div>

        <div style="flex: 2; min-width: 300px;">
            <h1 style="font-size: 38px; color: #2c3e50; margin-bottom: 20px;">{{ $author->TenTacGia }}</h1>
            
            <div style="line-height: 1.8; color: #555; font-size: 16px;">
                <h4 style="color: #34495e; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Tiểu sử</h4>
                {!! nl2br(e($author->GioiThieu)) !!}
            </div>

            <div style="margin-top: 30px; display: flex; gap: 30px;">
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c3e50;">{{ $author->sachs->count() }}</div>
                    <div style="color: #7f8c8d; font-size: 14px;">Tác phẩm</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c3e50;">{{ number_format($author->sachs->sum('LuotXem')) }}</div>
                    <div style="color: #7f8c8d; font-size: 14px;">Lượt xem</div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h2 style="margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
            <i class="fas fa-book-open" style="color: #3498db;"></i> 
            Tác phẩm tiêu biểu của {{ $author->TenTacGia }}
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px;">
            @forelse($author->sachs as $book)
                {{-- Tái sử dụng partial đã tạo ở phần Book --}}
                @include('frontend.books.partials.book_item', ['book' => $book])
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #95a5a6; padding: 40px;">
                    Hiện chưa có danh sách sách của tác giả này.
                </p>
            @endforelse
        </div>
    </div>
</div>
@endsection