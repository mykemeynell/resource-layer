<?php

namespace ResourceLayer\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ResourceLayer\Console\Commands;
use ResourceLayer\Resources\Resource;

class ResourceLayerServiceProvider extends ServiceProvider
{
    private array $resources = [];

    public function __construct($app)
    {
        $this->resources = config('resource-layer.resources', []);
        parent::__construct($app);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../publishables/config/resource-layer.php' => config_path('resource-layer.php')
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../publishables/config/resource-layer.php', 'resource-layer',
        );

        $this->commands([
            Commands\MakeResourceCommand::class,
        ]);
    }

    public function register()
    {
        $this->registerResources();
    }

    protected function registerResources(): void
    {
        $instances = [];
        foreach ($this->resources as $resource) {
            /** @var Resource $instance */
            $instance = $this->app->make($resource);
            $instances[$instance->getResourceType()] = $instance;
        }

        $this->app->singleton(
            abstract: "resources",
            concrete: fn () => $instances
        );
    }
}
