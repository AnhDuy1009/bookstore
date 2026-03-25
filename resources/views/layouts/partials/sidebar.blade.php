<div class="admin-sidebar shadow">
    <div class="sidebar-brand p-4 text-center">
        <h3 style="color: #ff9f43; font-weight: bold; letter-spacing: 1px;">HIỆN SÁCH</h3>
        <p class="text-muted small">Hệ thống Quản trị</p>
    </div>

    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie me-2"></i> Bảng điều khiển
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.books.index') }}" 
            class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="fas fa-book me-2"></i> 
                <span style="color: #ff9f43; font-weight: 500;">Quản lý Sách</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> Danh mục sách
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart me-2"></i> Đơn hàng
            </a>
        </li>
       <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" 
            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield me-2"></i> 
                <span style="color: #ff9f43; font-weight: 500;">Quản lý Người dùng</span>
            </a>
        </li>
        <li class="nav-item mt-4 border-top pt-3">
            <a href="{{ route('home') }}" class="nav-link text-info" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i> Xem trang chủ
            </a>
        </li>
    </ul>
</div>