<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\IBookRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IBookRepository::class, BookRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
