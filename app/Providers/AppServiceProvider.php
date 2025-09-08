<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {

            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);

            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Builder::macro('selectAvgTimeDiffInHours', function ($startColumn, $endColumn, $alias = 'avg_duration_hours') {
        $driver = DB::getDriverName();

        $expression = match ($driver) {
            'sqlite' => "COALESCE(AVG((strftime('%s', {$endColumn}) - strftime('%s', {$startColumn})) / 3600.0), 0)",
            'mysql'  => "COALESCE(AVG(TIMESTAMPDIFF(SECOND, {$startColumn}, {$endColumn}) / 3600), 0)",
            'pgsql'  => "COALESCE(AVG(EXTRACT(EPOCH FROM ({$endColumn} - {$startColumn})) / 3600), 0)",
            default  => "0",
        };

        return $this->addSelect(DB::raw("{$expression} as {$alias}"));
    });

    EloquentBuilder::macro('selectAvgTimeDiffInHours', function ($startColumn, $endColumn, $alias = 'avg_duration_hours') {
        $driver = DB::getDriverName();

        $expression = match ($driver) {
            'sqlite' => "COALESCE(AVG((strftime('%s', {$endColumn}) - strftime('%s', {$startColumn})) / 3600.0), 0)",
            'mysql'  => "COALESCE(AVG(TIMESTAMPDIFF(SECOND, {$startColumn}, {$endColumn}) / 3600), 0)",
            'pgsql'  => "COALESCE(AVG(EXTRACT(EPOCH FROM ({$endColumn} - {$startColumn})) / 3600), 0)",
            default  => "0",
        };

        return $this->addSelect(DB::raw("{$expression} as {$alias}"));
    });

    }
}
