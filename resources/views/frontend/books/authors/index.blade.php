@extends('layouts.app')

@section('title', 'Danh sách tác giả')

@section('content')
<div class="container" style="padding: 40px 0;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="color: #2c3e50; font-size: 36px;">Tác giả của chúng tôi</h1>
        <p style="color: #7f8c8d;">Khám phá những tâm hồn sáng tạo đằng sau những cuốn sách hay nhất.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px;">
        @foreach($authors as $author)
            <div class="author-card" style="background: #fff; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s;">
                <a href="{{ route('authors.show', $author->id) }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ $author->Link_Chan_Dung }}" 
                         alt="{{ $author->TenTacGia }}" 
                         style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 4px solid #f8f9fa;">
                    
                    <h3 style="margin-bottom: 10px; color: #2c3e50;">{{ $author->TenTacGia }}</h3>
                    <p style="font-size: 14px; color: #95a5a6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px;">
                        {{ $author->GioiThieu }}
                    </p>
                    <div style="margin-top: 15px; color: #3498db; font-weight: bold;">
                        {{ $author->books_count ?? $author->sachs->count() }} Tác phẩm
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 40px; text-align: center;">
        {{ $authors->links() }}
    </div>
</div>
@endsection