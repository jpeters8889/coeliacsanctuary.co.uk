<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Carbon\Laravel\ServiceProvider;
use Coeliac\Base\Modules;
use Coeliac\Common\MjmlCompiler\CoeliacCompiler;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Notifications\Channels\MailChannel;
use DirectoryIterator;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Notifications\Channels\MailChannel as IlluminateMailChannel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\ExcelServiceProvider;

class CoeliacServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        if ($this->app->runningUnitTests()) {
            $this->app->make(Repository::class)->set('filesystems.disks.images.root', storage_path('testing'));
        }

        $this->app->register(ExcelServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(NewsletterServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->instance(CompilerContract::class, new CoeliacCompiler());

        $this->app->alias(MailChannel::class, IlluminateMailChannel::class);

        $this->bootstrapModules();

        Collection::macro('ray', fn () => $this);
    }

    private function bootstrapModules(): void
    {
        $directory = app_path('Modules');

        foreach (new DirectoryIterator($directory) as $module) {
            if ($module->isDot()) {//
                continue;
            }

            if ($module->isDir()) {
                $this->bootstrapModule($module);
            }
        }
    }

    private function bootstrapModule(DirectoryIterator $module): void
    {
        $basename = $module->getBasename();

        $classPath = "Coeliac\\Modules\\{$basename}\\Module";

        /** @var Modules $module */
        $module = new $classPath();

        foreach ($module->getProviders() as $provider) {
            $this->app->register($provider);
        }
    }
}
