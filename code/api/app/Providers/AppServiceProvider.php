<?php

namespace App\Providers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Interfaces\Api\JsonPlaceHolderRepositoryInterface;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;
use Project\Infrastructure\Repository\Api\JsonPlaceHolderApiRepository;
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
        $this->app->singleton(Client::class, static function () {
            return new Client([
                'base_uri' => env('JSON_PLACEHOLDER_BASE_URL'),
            ]);
        });

        $this->app->bind(
            JsonPlaceHolderRepositoryInterface::class,
            JsonPlaceHolderApiRepository::class
        );

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
