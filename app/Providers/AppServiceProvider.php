<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
use App\Policies\AdminPolicy;

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
        //
        Gate::policy(Admin::class, AdminPolicy::class);
    }
}
