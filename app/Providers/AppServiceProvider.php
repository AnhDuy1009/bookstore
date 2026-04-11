<?php

namespace App\Providers;

// Đổi về đúng chuẩn ServiceProvider của App
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

// Import các Model của bạn
use App\Models\Book;
use App\Models\Order;
use App\Models\User;

// Import các Policy tương ứng
use App\Policies\BookPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Book::class => BookPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
    ];


    public function register(): void
    {
        //
    }


    public function boot(): void
    {
       
        Paginator::useBootstrapFive();

     
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

       
        Gate::before(function ($user, $ability) {
       
            return ($user->VaiTro === 'admin' || $user->Role === 'admin') ? true : null;
        });

       
        Gate::define('view-statistics', function ($user) {
            return ($user->VaiTro === 'admin' || $user->Role === 'admin');
        });
    }
}