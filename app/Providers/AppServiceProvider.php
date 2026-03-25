<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

// TODO: Import các Model
use App\Models\Book;
use App\Models\Order;
use App\Models\User;

// TODO: Import các Policy tương ứng
use App\Policies\BookPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bản đồ đăng ký các Policy cho Model.
     * * @var array<class-string, class-string>
     */
    protected $policies = [
        // TODO: Đăng ký quan hệ giữa Model và Policy
        Book::class => BookPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Đăng ký bất kỳ dịch vụ xác thực / ủy quyền nào.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $this->registerPolicies();

        // TODO: Định nghĩa một "Super Admin" Gate
        // Gate này cho phép Admin luôn có quyền thực hiện mọi hành động mà không cần check Policy lẻ
        Gate::before(function ($user, $ability) {
            return $user->VaiTro === 'admin' ? true : null;
        });

        // TODO: Định nghĩa thêm các Gate nhỏ lẻ nếu không muốn dùng Policy (Ví dụ: xem báo cáo)
        Gate::define('view-statistics', function ($user) {
            return $user->VaiTro === 'admin';
        });
    }
}