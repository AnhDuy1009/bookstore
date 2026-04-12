@extends('layouts.app')

@section('title', 'Lịch sử đánh giá của tôi')

@section('content')
<div class="container" style="padding: 40px 0;">
    <h2 style="margin-bottom: 30px; color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <i class="fas fa-star" style="color: #f1c40f;"></i> Lịch sử đánh giá của tôi
    </h2>

    {{-- Thông báo thành công nếu có --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Kiểm tra nếu không có đánh giá nào --}}
    @if($reviews->isEmpty())
        <div style="background: #f9f9f9; padding: 50px 20px; text-align: center; border-radius: 10px;">
            <i class="far fa-comment-dots" style="font-size: 60px; color: #bdc3c7; margin-bottom: 15px;"></i>
            <p style="color: #7f8c8d; font-size: 18px; margin-bottom: 20px;">Bạn chưa có bài đánh giá nào.</p>
            <a href="{{ route('books.index') ?? '#' }}" style="background: #3498db; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                Khám phá sách ngay
            </a>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($reviews as $review)
                <div style="background: #fff; padding: 25px; ...">
                    <h4 style="...">
                        {{-- Sử dụng quan hệ 'book' và cột 'TenSach' trong database --}}
                        Đánh giá cho sách: <span style="...">{{ $review->book->TenSach ?? 'Sách không còn tồn tại' }}</span>
                    </h4>
                    
                    <div style="color: #f1c40f; ...">
                        @for($i = 1; $i <= 5; $i++)
                            {{-- Sửa rating -> DiemDanhGia --}}
                            @if($i <= $review->DiemDanhGia)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span style="...">
                            {{-- Sửa created_at -> NgayDanhGia --}}
                            <i class="far fa-clock"></i> {{ date('d/m/Y H:i', strtotime($review->NgayDanhGia)) }}
                        </span>
                    </div>
                    
                    {{-- Sửa content -> NoiDung --}}
                    <div style="...">
                        "{{ $review->NoiDung }}"
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection