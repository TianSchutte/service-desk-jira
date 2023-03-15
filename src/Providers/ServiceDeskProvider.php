<?php

namespace TianSchutte\ServiceDeskJira\Providers;

use Illuminate\Support\ServiceProvider;
use TianSchutte\ServiceDeskJira\Console\Commands\BaseCommand;
use TianSchutte\ServiceDeskJira\Middleware\FloatingButtonMiddleware;
use TianSchutte\ServiceDeskJira\Services\JiraServiceDeskService;


class ServiceDeskProvider extends ServiceProvider
{
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
            __DIR__ . '/../resources/public' => public_path('vendor/courier'),
        ], 'public');

        $this->setupDefaults();
        $this->setupFloatingButtonMiddleware();
        $this->setupJiraServiceDeskService();
    }

    private function setupDefaults()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'service-desk-jira');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BaseCommand::class,
            ]);
        }
    }

    private function setupFloatingButtonMiddleware()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', FloatingButtonMiddleware::class);
    }

    private function setupJiraServiceDeskService()
    {
        $this->app->singleton('service-desk-jira', function ($app) {
            $baseUrl = config('service-desk-jira.base_url');
            $email = config('service-desk-jira.email');
            $apiKey = config('service-desk-jira.api_key');
            return new JiraServiceDeskService($baseUrl, $email, $apiKey);
        });
    }
}
