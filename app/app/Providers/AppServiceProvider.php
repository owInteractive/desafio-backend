<?php

namespace App\Providers;

use App\Services\Transactions\TransactionService;
use App\Services\Transactions\TransactionServiceContract;
use App\Services\Users\UserServiceContract;
use App\Services\Users\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(TransactionServiceContract::class, TransactionService::class);
    }
}
