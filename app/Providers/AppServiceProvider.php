<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        
        if (config('app.env') === 'local') {
            \DB::listen(function($query) {
                echo"<pre>";print_r($query->sql);echo"</pre>";
                echo"<pre>";print_r($query->bindings);echo"</pre>";
                \Log::info($query->sql, [
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]);
            });
        }

    }
}
