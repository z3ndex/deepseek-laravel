<?php

namespace DeepseekPhp\DeepseekLaravel;

use DeepseekPhp\DeepseekClient;
use Illuminate\Support\ServiceProvider;

class DeepseekLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/deepseek.php' => config_path('deepseek.php'),
            ], 'deepseek');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/deepseek.php', 'deepseek');

        $this->app->singleton('DeepseekClient', function () {
            $apiKey = config('deepseek.api_key');
            $baseUrl = config('deepseek.base_url');
            $timeout = config('deepseek.timeout');

            return DeepseekClient::build($apiKey, $baseUrl, $timeout);
        });
    }
}
