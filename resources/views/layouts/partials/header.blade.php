<header class="main-header">
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <i class="fas fa-book"></i>
                    <span>Hiên Sách</span>
                </a>
            </div>
            
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><a href="{{ route('books.index') }}">Danh mục</a></li>
                <li><a href="{{ route('books.bestseller') }}">Sách bán chạy</a></li>
                <li>
                    <a href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        <span class="badge cart-count" style="background: red; color: white; padding: 2px 6px; border-radius: 50%; font-size: 10px; margin-left: 5px;">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </li>
            </ul>
            
            <div class="nav-actions">
                @auth
                    <div class="user-menu" style="display: flex; align-items: center; gap: 15px;">
                        <span>Xin chào, <strong>{{ Auth::user()->HoTen }}</strong></span>
                        
                        <a href="{{ route('profile.index') }}" class="btn-user">Tài khoản</a>

                        {{-- SỬA: Kiểm tra IDQuyen theo Database của bạn (giả sử 1 là admin) --}}
                        @if(Auth::user()->IDQuyen == 1)
                            <a href="/admin" class="btn-admin" style="color: #e74c3c; font-weight: bold;">
                                <i class="fas fa-user-shield"></i> Quản trị
                            </a>
                        @endif

                        {{-- CHỈ GIỮ 1 FORM LOGOUT --}}
                        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-logout-link" style="background: none; border: none; color: #7f8c8d; cursor: pointer; font: inherit;">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn-register" style="margin-left: 10px;">Đăng ký</a>
                @endauth
            </div>
        </nav>
    </div>
</header>