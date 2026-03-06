<?php

namespace Roots\AcornUserRoles;

use Illuminate\Support\ServiceProvider;

class AcornUserRolesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Roots\AcornUserRoles', fn () => AcornUserRoles::make($this->app));

        $this->mergeConfigFrom(
            __DIR__.'/../config/user-roles.php',
            'user-roles'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/user-roles.php' => $this->app->configPath('user-roles.php'),
        ], 'config');

        /**
         * Register user roles on WordPress init.
         */
        add_action('init', function (): void {
            $this->app->make('Roots\AcornUserRoles');
        }, 100);
    }
}
