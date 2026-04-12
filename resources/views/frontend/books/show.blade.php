@extends('layouts.app')

@section('title', $book->TenSach)

@section('content')
<div class="container" style="padding: 40px 0;">
    {{-- 1. THÔNG TIN CHI TIẾT SÁCH --}}
    <div style="background: #fff; padding: 30px; border-radius: 15px; display: flex; gap: 50px; flex-wrap: wrap; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <div style="flex: 1; min-width: 350px;">
            <img src="{{ asset('storage/' . $book->Link_image) }}" style="width: 100%; object-fit: contain;border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>

        <div style="flex: 1.5; min-width: 350px;">
            <nav style="color: #7f8c8d; margin-bottom: 10px;">
                Trang chủ / {{ $book->danhMuc->TenDanhMuc ?? 'Danh mục' }} / {{ $book->TenSach }}
            </nav>
            <h1 style="font-size: 32px; margin-bottom: 10px;">{{ $book->TenSach }}</h1>
            
            <div style="margin-bottom: 20px;">
                Tác giả: <a href="{{ route('authors.show', $book->IDTacGia) }}" style="color: #3498db; font-weight: bold;">{{ $book->tacGia->TenTacGia ?? 'Đang cập nhật' }}</a>
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

            <form action="{{ route('cart.add', $book->id ?? $book->ID) }}" method="POST">
                @csrf
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 5px;">
                        <button type="button" id="btn-minus" style="padding: 10px 15px; border: none; background: none;">-</button>
                        <input type="number" name="quantity" value="1" style="width: 50px; text-align: center; border: none;">
                        <button type="button" id="btn-plus" style="padding: 10px 15px; border: none; background: none;">+</button>
                    </div>
                    <button type="submit" style="flex-grow: 1; background: #e74c3c; color: white; border: none; padding: 15px; border-radius: 5px; font-weight: bold; font-size: 18px; cursor: pointer;">
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. KHU VỰC ĐÁNH GIÁ SÁCH (Mới thêm) --}}
    <div id="review-form" style="background: #fff; padding: 30px; border-radius: 15px; margin-top: 40px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h3 style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">Đánh giá cuốn sách này</h3>

        {{-- Hiển thị thông báo Lỗi hoặc Thành công --}}
        @if(session('error'))
            <div style="color: #721c24; background: #f8d7da; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Form Đánh Giá --}}
        @auth
                @php
                // Kiểm tra xem người dùng hiện tại đã mua và nhận cuốn sách này chưa
                $daMuaVaNhanHang = DB::table('don_hang')
                    ->join('chi_tiet_don_hang', 'don_hang.ID', '=', 'chi_tiet_don_hang.IDDonHang')
                    ->where('don_hang.IDNguoiDung', Auth::id())
                    ->where('chi_tiet_don_hang.IDSach', $book->ID)
                    ->where('don_hang.TrangThai', 'Đã giao')
                    ->exists();
                @endphp
             @if($daMuaVaNhanHang)
              {{-- CHỈ HIỆN FORM KHI ĐÃ MUA VÀ NHẬN HÀNG --}}   
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                {{-- Truyền ngầm ID của cuốn sách đang xem --}}
                <input type="hidden" name="book_id" value="{{ $book->ID }}">

                <div style="margin-bottom: 15px;">
                    <label for="rating" style="font-weight: bold; color: #333;">Chất lượng sách:</label><br>
                    <select name="rating" id="rating" style="padding: 10px; width: 220px; margin-top: 8px; border-radius: 5px; border: 1px solid #ccc;" required>
                        <option value="5">⭐⭐⭐⭐⭐ 5 Sao (Tuyệt vời)</option>
                        <option value="4">⭐⭐⭐⭐ 4 Sao (Rất tốt)</option>
                        <option value="3">⭐⭐⭐ 3 Sao (Bình thường)</option>
                        <option value="2">⭐⭐ 2 Sao (Kém)</option>
                        <option value="1">⭐ 1 Sao (Tệ)</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="content" style="font-weight: bold; color: #333;">Nội dung đánh giá:</label><br>
                    <textarea name="content" id="content" rows="4" style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box;" placeholder="Bạn cảm nhận thế nào về cuốn sách này? Hãy chia sẻ nhé..." required></textarea>
                </div>

                <button type="submit" style="background: #27ae60; color: white; border: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                    Gửi Đánh Giá
                </button>
            </form>
            @else
                {{-- TRƯỜNG HỢP 2: ĐÃ ĐĂNG NHẬP + CHƯA MUA HÀNG --}}
                    <div style="padding: 20px; background: #fff3cd; color: #856404; border-radius: 8px; border: 1px solid #ffeeba; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-info-circle"></i>
                        <span>Bạn cần <b>mua sách</b> và đơn hàng ở trạng thái <b>"Đã giao"</b> mới có thể đánh giá.</span>
                    </div>
                @endif
        @else
            {{-- Giao diện khi chưa đăng nhập (Giữ nguyên) --}}
            <div style="text-align: center; padding: 25px; background: #f8f9fa; border-radius: 8px;">
                <p style="color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem;">
                    Bạn muốn chia sẻ cảm nhận về cuốn sách này? <br>
                    <span style="font-size: 14px; color: #7f8c8d;">Hãy đăng nhập để gửi đánh giá ngay nhé!</span>
                </p>
                <a href="{{ route('login') }}" style="display: inline-block; background: #3498db; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; transition: 0.3s;">
                    Đăng Nhập Ngay
                </a>
            </div>
        @endauth
        {{-- --- HIỂN THỊ DANH SÁCH CÁC ĐÁNH GIÁ ĐÃ CÓ --- --}}
        <div style="margin-top: 40px; border-top: 1px dashed #ddd; padding-top: 25px;">
            <h4 style="margin-bottom: 20px; color: #333;">Tất cả đánh giá ({{ count($reviews) }})</h4>

            @forelse($reviews as $review)
                <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f1f1f1; display: flex; gap: 15px;">
                    <div style="width: 50px; height: 50px; background: #3498db; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">
                        {{ substr($review->user->name ?? 'U', 0, 1) }}
                    </div>

                    <div style="flex-grow: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                            <strong style="color: #2c3e50;">{{ $review->user->name ?? 'Người dùng ẩn danh' }}</strong>
                            <span style="font-size: 13px; color: #95a5a6;">
                                <i class="far fa-clock"></i> {{ date('d/m/Y', strtotime($review->NgayDanhGia)) }}
                            </span>
                        </div>

                        <div style="color: #f1c40f; margin-bottom: 8px; font-size: 14px;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->DiemDanhGia)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star" style="color: #ddd;"></i>
                                @endif
                            @endfor
                            <span style="color: #7f8c8d; margin-left: 5px;">({{ $review->DiemDanhGia }} sao)</span>
                        </div>

                        <p style="color: #555; line-height: 1.6; margin: 0; background: #f9f9f9; padding: 10px; border-radius: 8px;">
                            {{ $review->NoiDung }}
                        </p>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #95a5a6; padding: 20px;">
                    <i class="fas fa-comment-slash" style="font-size: 30px; margin-bottom: 10px; display: block;"></i>
                    Chưa có đánh giá nào cho cuốn sách này. Hãy là người đầu tiên đánh giá!
                </div>
            @endforelse
            <script>
                document.getElementById('btn-plus').onclick = function() {
                    let input = document.querySelector('input[name="quantity"]');
                    input.value = parseInt(input.value) + 1;
                };
                document.getElementById('btn-minus').onclick = function() {
                    let input = document.querySelector('input[name="quantity"]');
                    if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
                };
</script>
        </div>
    </div>

    {{-- 3. SÁCH CÙNG THỂ LOẠI --}}
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