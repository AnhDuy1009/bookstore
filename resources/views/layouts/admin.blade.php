<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; }
        body { background-color: #f4f7f6; overflow-x: hidden; }
        
        .admin-sidebar { 
            width: var(--sidebar-width); 
            height: 100vh; 
            position: fixed; 
            background: #fff; 
            border-right: 1px solid #e0e0e0; 
            z-index: 1000; 
        }
        
        .main-content { 
            margin-left: var(--sidebar-width); 
            min-height: 100vh; 
            padding: 25px; 
        }
        
        .nav-link { 
            color: #555; 
            padding: 12px 20px; 
            font-weight: 500; 
            border-radius: 8px; 
            margin: 4px 15px; 
            transition: all 0.2s ease-in-out; 
        }
        
       
        .nav-link:hover, .nav-link.active { 
            background: #e6f0ff; 
            color: #0d6efd !important; 
        } 
        
        .topbar { 
            background: #fff; 
            padding: 15px 30px; 
            border-bottom: 1px solid #e0e0e0; 
            margin-bottom: 25px; 
            border-radius: 12px; 
        }
        
    </style>
</head>
<body>
  
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