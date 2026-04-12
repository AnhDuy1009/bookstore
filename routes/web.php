<?php

use Illuminate\Support\Facades\Route;

// --- FRONTEND CONTROLLERS ---
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BookController; 
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\ReviewController as FrontendReviewController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Api\SearchApiController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\AdminController;
/*
|--------------------------------------------------------------------------
| 1. XÁC THỰC (AUTHENTICATION)
|--------------------------------------------------------------------------
*/
// Đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quên mật khẩu (Password Reset)
Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
    // Trang nhập email để nhận link reset
    Route::get('/reset', [AuthController::class, 'showForgotPassword'])->name('request');
    Route::post('/email', [AuthController::class, 'sendResetLinkEmail'])->name('email');

    // Trang nhập mật khẩu mới (từ link trong email)
    Route::get('/reset/{token}', [AuthController::class, 'showResetPassword'])->name('reset');
    Route::post('/reset', [AuthController::class, 'resetPassword'])->name('update');
});
/*
|--------------------------------------------------------------------------
| 2. TRANG CHỦ & DUYỆT SÁCH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/bestseller', [BookController::class, 'bestseller'])->name('books.bestseller');
Route::get('/danh-muc/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/authors/{id}', [BookController::class, 'author'])->name('authors.show');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
// API endpoint for search
Route::get('/api/search', [SearchApiController::class, 'search'])->name('api.search');

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');           // Tất cả sách
    Route::get('/category/{id}', [BookController::class, 'category'])->name('books.category'); // Lọc theo danh mục
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');     // Chi tiết sách
    Route::get('/search', [BookController::class, 'search'])->name('books.search');       // Tìm kiếm sách
    Route::get('/bestseller', [BookController::class, 'bestseller'])->name('books.bestseller');
});

/*
|--------------------------------------------------------------------------
| 3. GIỎ HÀNG (CART - SESSION BASED)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');           // Xem giỏ hàng
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');      // Thêm vào giỏ
    Route::post('/update', [CartController::class, 'update'])->name('update');  // Cập nhật số lượng (AJAX)
    Route::get('/remove/{id}', [CartController::class, 'remove'])->name('remove'); // Xóa món hàng
    Route::get('/clear', [CartController::class, 'clear'])->name('clear');      // Xóa hết giỏ
});

/*
|--------------------------------------------------------------------------
| 4. USER PROFILE & ORDERS (YÊU CẦU ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Hồ sơ cá nhân
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ProfileController::class, 'password'])->name('password');
        Route::get('/my-reviews', [FrontendReviewController::class, 'index'])->name('reviews');
    });

    // Quy trình thanh toán & Đơn hàng
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');   // Trang thanh toán
        Route::post('/process', [OrderController::class, 'process'])->name('process');     // Xử lý lưu DB
        Route::get('/success/{id}', [OrderController::class, 'success'])->name('success'); // Hoàn tất
        Route::get('/history', [OrderController::class, 'list'])->name('list');            // Lịch sử mua hàng
        Route::get('/track/{id}', [OrderController::class, 'track'])->name('track');       // Chi tiết đơn
        Route::post('/cancel/{id}', [OrderController::class, 'cancel'])->name('cancel');   // Hủy đơn hàng

    });

    // Đánh giá sản phẩm
    Route::post('/book/review', [FrontendReviewController::class, 'store'])->name('reviews.store');

});

/*
|--------------------------------------------------------------------------
| 5. HỆ THỐNG QUẢN TRỊ (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard chính -> Tên: admin.dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Các Resource (Tự động tạo admin.categories.index, admin.books.index, admin.users.index)
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('books', AdminBookController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // 3. Quản lý Đơn hàng (Chỉ cần .name('orders.') vì đã có 'admin.' ở ngoài)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index'); // -> admin.orders.index
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');   // -> admin.orders.show
        Route::patch('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/print', [AdminOrderController::class, 'print'])->name('print'); // -> admin.orders.print
    });

    // 4. Quản lý Đánh giá
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::patch('/approve-all', [ReviewController::class, 'approveAll'])->name('approveAll'); // URL: admin/reviews/approve-all
        Route::patch('/{id}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });
    
    // 5. Thống kê
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('/', [StatisticController::class, 'index'])->name('index'); // -> admin.statistics.index
        Route::get('/export', [StatisticController::class, 'export'])->name('export');
    });
    
});
