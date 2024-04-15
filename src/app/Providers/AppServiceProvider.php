<?php declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\GenListenersSummaryRepository;
use App\Repositories\Interfaces\IGenListenersSummaryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->bind(IGenListenersSummaryRepository::class, GenListenersSummaryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void {}
}
