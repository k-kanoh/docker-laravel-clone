<?php declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\FavoriteRepository;
use App\Repositories\Eloquent\GenListenersSummaryRepository;
use App\Repositories\Eloquent\NowPlayingRepository;
use App\Repositories\Interfaces\IFavoriteRepository;
use App\Repositories\Interfaces\IGenListenersSummaryRepository;
use App\Repositories\Interfaces\INowPlayingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->bind(INowPlayingRepository::class, NowPlayingRepository::class);
        $this->app->bind(IGenListenersSummaryRepository::class, GenListenersSummaryRepository::class);
        $this->app->bind(IFavoriteRepository::class, FavoriteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void {}
}
