<?php
namespace Phooty\Crawler;

use Phooty\Support\ServiceProvider;
use Phooty\Crawler\Factory\DataFactory;

class FactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $factories = $this->app->make('config')->get('phooty.crawler.factories');

        $factories = array_filter($factories, function ($val, $key) {
            return is_string($key)
                && class_exists($val)
                && (new \ReflectionClass($val))->implementsInterface(DataFactory::class);
        }, ARRAY_FILTER_USE_BOTH);
        
        foreach ($factories as $name => $factory) {
            $this->app->singleton($factory);
            $this->app->alias($factory, "factory.{$name}");
        }
    }
}
