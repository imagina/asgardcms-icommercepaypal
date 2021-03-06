<?php

namespace Modules\Icommercepaypal\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icommercepaypal\Events\Handlers\RegisterIcommercepaypalSidebar;

class IcommercepaypalServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercepaypalSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercepaypals', array_dot(trans('icommercepaypal::icommercepaypals')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icommercepaypal', 'permissions');
        $this->publishConfig('icommercepaypal', 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommercepaypal\Repositories\IcommercePaypalRepository',
            function () {
                $repository = new \Modules\Icommercepaypal\Repositories\Eloquent\EloquentIcommercePaypalRepository(new \Modules\Icommercepaypal\Entities\IcommercePaypal());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercepaypal\Repositories\Cache\CacheIcommercePaypalDecorator($repository);
            }
        );
// add bindings

    }
}
