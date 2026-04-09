<div class="book-card" style="background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s;">
    {{-- SỬA:$book->id thành$book->ID --}}
    <a href="{{ route('books.show',$book->ID) }}" style="text-decoration: none; color: inherit;">
        <div style="position: relative;">
            {{-- SỬA: Kiểm tra tên cột ảnh bìa trong SQL của bạn là gì (ví dụ: Hinh_Anh hoặc Link_Anh_Bia) --}}
            <img src="{{$book->Link_Anh_Bia }}" alt="{{$book->TenSach }}" 
                 style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
            
            @if($book->LuotXem > 100)
                <span style="position: absolute; top: 10px; right: 10px; background: #e74c3c; color: white; padding: 2px 8px; border-radius: 20px; font-size: 12px;">HOT</span>
            @endif
        </div>
        
        <h4 style="margin: 15px 0 5px; font-size: 16px; height: 40px; overflow: hidden;">{{$book->TenSach }}</h4>
        <p style="color: #7f8c8d; font-size: 13px; margin-bottom: 10px;">{{$book->tacGia->TenTacGia ?? 'Khuyết danh' }}</p>
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #e67e22; font-weight: bold; font-size: 18px;">{{ number_format($book->GiaBan) }}đ</span>
            <span style="color: #95a5a6; text-decoration: line-through; font-size: 13px;">{{ number_format($book->GiaBan * 1.1) }}đ</span>
        </div>
    </a>
    
    <div style="margin-top: 15px; display: flex; gap: 5px;">
        {{-- SỬA:$book->id thành$book->ID ở route thêm vào giỏ hàng --}}
        <form action="{{ route('cart.add',$book->ID) }}" method="POST" style="flex: 1;">
            @csrf
            <button class="btn-add" style="width: 100%; padding: 8px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
                <i class="fas fa-cart-plus"></i>
            </button>
        </form>
        
        {{-- TODO: Thêm route wishlist nếu đã định nghĩa --}}
        <button class="btn-wishlist" style="padding: 8px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 5px;">
            <i class="far fa-heart"></i>
        </button>
    </div>
</div>