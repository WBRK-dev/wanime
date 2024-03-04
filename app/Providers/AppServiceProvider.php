<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && in_array(auth()->user()->email, config('app.admin_email'))): ?>";
        });
    
        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

    }
}
