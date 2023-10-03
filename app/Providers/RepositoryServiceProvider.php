<?php

namespace App\Providers;

use App\Repository\BillerCategoryRepositoryInterface;
use App\Repository\BillerRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\BillerCategoryRepository;
use App\Repository\Eloquent\BillerRepository;
use App\Repository\Eloquent\JustpayBankRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\JustpayBankRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BillerCategoryRepositoryInterface::class, BillerCategoryRepository::class);
        $this->app->bind(JustpayBankRepositoryInterface::class, JustpayBankRepository::class);
        $this->app->bind(BillerRepositoryInterface::class, BillerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
