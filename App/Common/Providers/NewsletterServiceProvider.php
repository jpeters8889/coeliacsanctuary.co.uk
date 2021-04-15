<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Services\Mailcoach;

class NewsletterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::mailcoach('mailcoach');
        Route::sesFeedback('ses-feedback');

        Gate::define('viewMailcoach', function (User $user) {
            return in_array($user->email, ['jamie@jamie-peters.co.uk', 'contact@coeliacsanctuary.co.uk']);
        });

        $this->app->bind(
            NewsletterService::class,
            fn () => new Mailcoach(
                Container::getInstance()
                    ->make(Repository::class)
                    ->get('coeliac.newsletter.list')
            )
        );
    }
}
