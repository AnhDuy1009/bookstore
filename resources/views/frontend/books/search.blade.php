@extends('layouts.app')

@section('title', 'Tìm kiếm: ' . request('q'))

@section('content')
<div class="container" style="padding: 40px 0;">
    <div style="background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h2>Kết quả tìm kiếm cho: "<span style="color: #e74c3c;">{{ request('q') }}</span>"</h2>
        <p style="color: #7f8c8d;">Tìm thấy {{ $books->total() }} kết quả phù hợp</p>
    </div>

    @if($books->isEmpty())
        <div style="text-align: center; padding: 100px 0;">
            <i class="fas fa-search-minus" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
            <h3>Không tìm thấy cuốn sách nào!</h3>
            <p>Hãy thử tìm với từ khóa khác hoặc quay lại <a href="{{ route('books.index') }}">Danh mục sách</a></p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px;">
            @foreach($books as $book)
                @include('frontend.books.partials.book_item', ['book' => $book])
            @endforeach
        </div>
        
        <div style="margin-top: 40px;">
            {{ $books->appends(request()->input())->links() }}
        </div>
    @endif
</div>
@endsection