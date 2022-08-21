<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Services\Mailcoach;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @phpstan-ignore-next-line  */
        Route::mailcoach('mailcoach');
        /** @phpstan-ignore-next-line  */
        Route::sesFeedback('ses-feedback');

        Gate::define('viewMailcoach', fn (User $user) => in_array($user->email, [
            'jamie@jamie-peters.co.uk', 'contact@coeliacsanctuary.co.uk',
        ]));

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
