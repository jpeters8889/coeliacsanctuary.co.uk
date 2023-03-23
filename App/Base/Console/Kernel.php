<?php

declare(strict_types=1);

namespace Coeliac\Base\Console;

use Coeliac\Base\Console\Commands\CleanUpFileUploads;
use Coeliac\Base\Console\Commands\ClearPublicDirectories;
use Coeliac\Modules\EatingOut\WhereToEat\Console\SlugifyEateries;
use Coeliac\Modules\Member\Console\SendDailyUpdates;
use Coeliac\Modules\Member\Console\UpdateUserActivity;
use Coeliac\Modules\Recipe\Console\PrefixRecipesWithGlutenFree;
use Coeliac\Modules\Shop\Console\ApplyMassDiscounts;
use Coeliac\Modules\Shop\Console\CleanUpAddresses;
use Coeliac\Modules\Shop\Console\CloseBaskets;
use Coeliac\Modules\Shop\Console\PrepareReviewInvitations;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ApplyMassDiscounts::class,
        ClearPublicDirectories::class,
        CleanUpFileUploads::class,
        CloseBaskets::class,
        SendDailyUpdates::class,
        UpdateUserActivity::class,
        PrefixRecipesWithGlutenFree::class,
        SlugifyEateries::class,
        CleanUpAddresses::class,
        PrepareReviewInvitations::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('coeliac:shopCloseBaskets')->everyMinute();
        $schedule->command('coeliac:apply_mass_discounts')->everyMinute();
        $schedule->command('coeliac:clean_file_uploads')->everyMinute();
        $schedule->command('coeliac:send-shop-review-invitations')->everyMinute();
        $schedule->command('coeliac:clear_public_dirs')->daily();
        $schedule->command('coeliac:send_daily_updates')->dailyAt('17:00');
        $schedule->command('coeliac:update-user-activity')->everyFiveMinutes();

        $schedule->command('list')->thenPing('http://beats.envoyer.io/heartbeat/8YWokjIDBE2Dkzc');

        $schedule->command('backup:clean')->dailyAt('0:00');
        $schedule->command('backup:run')->dailyAt('00:30');

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('mailcoach:send-automation-mails')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-mails')->everyMinute();

        $schedule->command('mailcoach:run-automation-triggers')->everyMinute();
        $schedule->command('mailcoach:run-automation-actions')->everyMinute();

        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:calculate-automation-mail-statistics')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:cleanup-processed-feedback')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
    }
}
