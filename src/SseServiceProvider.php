<?php

namespace LuizFabianoNogueira\SseNotify;

use Illuminate\Support\ServiceProvider;

class SseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/sse.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->publishesMigrations([
            __DIR__.'/Migrations' => database_path('migrations'),
        ], 'sse-notify-migrations');

        $this->publishes([
            __DIR__.'/Resources/js' => public_path('assets/js'),
        ], 'sse-notify-assets');
    }
}
