<?php

namespace App\Providers;

use App\Models\Book;
use App\Repositories\Contracts\BookRepository;
use App\Repositories\EloquentBookRepository;
use Illuminate\Support\ServiceProvider;

class  RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( BookRepository::class, function () {
            return new EloquentBookRepository( new Book() );
        } );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Book::class,
        ];
    }
}
