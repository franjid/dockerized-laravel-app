<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;
use Project\Infrastructure\Repository\Database\UserEloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, static function () {
            return new UserEloquentRepository(new User());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
