<div class="admin-sidebar d-flex flex-column h-100">
    {{-- LOGO --}}
    <div class="text-center py-4 border-bottom mb-3">
        <h2 class="fw-bold mb-1" style="color: #0077ff; letter-spacing: 1px;">HIÊN SÁCH</h2>
        <small class="text-muted">Hệ thống Quản trị</small>
    </div>

    {{-- MENU CHÍNH --}}
    <ul class="nav flex-column mb-auto px-2">
        <li class="nav-item">
           
            <a href="{{ url('admin') }}" class="nav-link d-flex align-items-center gap-3 {{ request()->is('admin') ? 'active' : '' }}">
                <i class="fas fa-chart-pie fa-fw"></i> Bảng điều khiển
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/books') }}" class="nav-link d-flex align-items-center gap-3 {{ request()->is('admin/books*') ? 'active' : '' }}">
                <i class="fas fa-book fa-fw"></i> Quản lý Sách
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/categories') }}" class="nav-link d-flex align-items-center gap-3 {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fas fa-tags fa-fw"></i> Danh mục sách
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/orders') }}" class="nav-link d-flex align-items-center gap-3 {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart fa-fw"></i> Đơn hàng
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/users') }}" class="nav-link d-flex align-items-center gap-3 {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-user-shield fa-fw"></i> Quản lý Người dùng
            </a>
        </li>
    </ul>

    {{-- NÚT XEM TRANG CHỦ --}}
    <div class="p-3 mt-auto border-top">
        <a href="{{ url('/') }}" class="nav-link d-flex align-items-center gap-3 text-info" target="_blank">
            <i class="fas fa-external-link-alt fa-fw"></i> Xem trang chủ
        </a>
    </div>
</div>