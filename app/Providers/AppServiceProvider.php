<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
