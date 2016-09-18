<?php namespace App\Providers;

use App\Repositories\Auth\EloquentUserRepository;
use App\Repositories\Auth\UserRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register view composers
        view()->composer(
            ['backend.layouts.partials.navigation.menu'],
            \App\ViewComposers\Backend\Menu\MainNavigationComposer::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDevelopmentBindings();
        $this->registerBindings();
    }

    /**
     * Register service provider used only when DEBUG is enabled
     */
    private function registerDevelopmentBindings()
    {
        if ( !config('app.debug', false)) return;

        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }

    /**
     * Register service provider bindings
     */
    private function registerBindings()
    {
        // Our repositories
        $this->app->bind(UserRepositoryContract::class, EloquentUserRepository::class);
    }
}
