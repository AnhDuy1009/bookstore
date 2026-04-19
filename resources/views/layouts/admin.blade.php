<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="admin-body">
  
    @include('layouts.partials.sidebar')

    <div class="main-content">
        <div class="topbar shadow-sm d-flex justify-content-between align-items-center">
           
            <h5 class="m-0 fw-bold text-primary">@yield('title')</h5>
            <div class="user-box d-flex align-items-center">
                <span class="me-3 small text-muted">Chào, <strong>{{ Auth::user()->HoTen ?? 'Quản trị viên' }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Đăng xuất">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>