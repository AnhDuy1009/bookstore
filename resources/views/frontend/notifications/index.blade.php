@extends('layouts.app')

@section('title', 'Thông báo của tôi')

@section('content')
<div class="container" style="padding: 40px 0; max-width: 800px; margin: 0 auto;">
    <h2 style="margin-bottom: 30px; color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <i class="fas fa-bell" style="color: #e74c3c;"></i> Thông báo của bạn
    </h2>

    @if($notifications->isEmpty())
        <div style="background: #f9f9f9; padding: 50px 20px; text-align: center; border-radius: 10px;">
            <i class="far fa-bell-slash" style="font-size: 60px; color: #bdc3c7; margin-bottom: 15px;"></i>
            <p style="color: #7f8c8d; font-size: 18px;">Bạn không có thông báo nào mới.</p>
        </div>
    @else
        <div style="background: #fff; border-radius: 10px; box-shadow: 0 3px 15px rgba(0,0,0,0.05); overflow: hidden;">
            @foreach($notifications as $notify)
                {{-- Logic: Thông báo chưa đọc (is_read = 0) sẽ có nền màu xanh nhạt và chữ đậm --}}
                <div style="padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; gap: 20px; align-items: flex-start;
                            background-color: {{ $notify->is_read ? '#fff' : '#f0f8ff' }}; transition: background 0.3s;">
                    
                    {{-- Icon chuông --}}
                    <div style="background: {{ $notify->is_read ? '#ecf0f1' : '#3498db' }}; 
                                color: {{ $notify->is_read ? '#95a5a6' : '#fff' }}; 
                                width: 45px; height: 45px; border-radius: 50%; display: flex; justify-content: center; align-items: center; flex-shrink: 0; font-size: 18px;">
                        <i class="fas fa-envelope{{ $notify->is_read ? '-open' : '' }}"></i>
                    </div>

                    {{-- Nội dung thông báo --}}
                    <div style="flex-grow: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <h4 style="margin: 0; color: #2c3e50; font-weight: {{ $notify->is_read ? 'normal' : 'bold' }};">
                                {{ $notify->title }}
                            </h4>
                            <span style="color: #95a5a6; font-size: 12px; white-space: nowrap;">
                                {{-- Hiển thị thời gian kiểu "5 phút trước" --}}
                                {{ $notify->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p style="margin: 0; color: {{ $notify->is_read ? '#7f8c8d' : '#2c3e50' }}; line-height: 1.5;">
                            {{ $notify->message }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection