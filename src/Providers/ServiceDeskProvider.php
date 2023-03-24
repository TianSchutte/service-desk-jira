<?php

namespace TianSchutte\ServiceDeskJira\Providers;

use Illuminate\Support\ServiceProvider;
use TianSchutte\ServiceDeskJira\Console\Commands\ListTicketsByEmailCommand;
use TianSchutte\ServiceDeskJira\Console\Commands\ServiceDeskInfoCommand;
use TianSchutte\ServiceDeskJira\Middleware\FloatingButtonMiddleware;


class ServiceDeskProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/servicedeskjira.php', 'service-desk-jira');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //config
        $this->publishes([
            __DIR__ . '/../config/servicedeskjira.php' => config_path('servicedeskjira.php'),
        ], 'config');

        //css
        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/servicedeskjira'),
        ], 'public');

        $this->setupDefaults();
        $this->setupFloatingButtonMiddleware();
    }

    /**
     * @return void
     */
    private function setupDefaults()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'service-desk-jira');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ListTicketsByEmailCommand::class,
                ServiceDeskInfoCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    private function setupFloatingButtonMiddleware()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', FloatingButtonMiddleware::class);
    }

}
