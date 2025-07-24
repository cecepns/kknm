<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\PermissionHelper;

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
        // Register Blade directives for permission checking
        Blade::if('permission', function ($permission) {
            return PermissionHelper::hasPermission($permission);
        });

        Blade::if('anyPermission', function ($permissions) {
            return PermissionHelper::hasAnyPermission($permissions);
        });

        Blade::if('allPermissions', function ($permissions) {
            return PermissionHelper::hasAllPermissions($permissions);
        });
    }
}
