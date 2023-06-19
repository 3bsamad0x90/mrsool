<?php

namespace App\Providers;


use App\Repositories\Authintication\AuthModelRepository;
use App\Repositories\Authintication\AuthRepository;
use Illuminate\Support\ServiceProvider;

class OtpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepository::class, function () {
            return new AuthModelRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
