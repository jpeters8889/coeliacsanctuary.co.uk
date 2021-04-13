<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Events\UserPasswordReset;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Listeners\LimitUserAccount;
use Coeliac\Modules\Member\Listeners\LogPasswordChange;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;
use Coeliac\Modules\Member\Listeners\CreateUserScrapbook;
use Coeliac\Modules\Member\Listeners\SendEmailChangedAlert;
use Coeliac\Modules\Member\Listeners\SendPasswordResetAlert;
use Coeliac\Modules\Member\Listeners\SendPasswordChangedAlert;
use Coeliac\Modules\Member\Listeners\FindEligibleDailyUpdatesToQueue;
use Coeliac\Modules\Member\Listeners\SendEmailUpdatedVerificationEmail;
use Coeliac\Modules\Member\Listeners\SendRegistrationConfirmationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            CreateUserScrapbook::class,
            SendRegistrationConfirmationEmail::class,
        ],

        UserEmailChanged::class => [
            LimitUserAccount::class,
            SendEmailChangedAlert::class,
            SendEmailUpdatedVerificationEmail::class,
        ],

        UserPasswordUpdated::class => [
            SendPasswordChangedAlert::class,
            LogPasswordChange::class,
        ],

        UserPasswordReset::class => [
            SendPasswordResetAlert::class,
            LogPasswordChange::class,
        ],

        DailyUpdateItemCreated::class => [
            FindEligibleDailyUpdatesToQueue::class,
        ],
    ];
}
