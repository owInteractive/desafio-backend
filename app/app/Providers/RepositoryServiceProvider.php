<?php

namespace App\Providers;

use App\Repositories\Transactions\TransactionRepository;
use App\Repositories\Transactions\TransactionRepositoryContract;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(TransactionRepositoryContract::class, TransactionRepository::class);
    }
}