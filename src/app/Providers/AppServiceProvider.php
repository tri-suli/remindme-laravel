<?php

namespace App\Providers;

use App\Http\Controllers\Api\ReminderController;
use App\Models\PersonalAccessToken;
use App\Repositories\ReminderRepository;
use App\Repositories\Repository;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        $this->app
            ->when(ReminderController::class)
            ->needs(Repository::class)
            ->give(ReminderRepository::class);
    }
}
