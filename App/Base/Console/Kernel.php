<?php

declare(strict_types=1);

namespace Coeliac\Base\Console;

use Illuminate\Console\Scheduling\Schedule;
use Coeliac\Modules\Shop\Console\CloseBaskets;
use Coeliac\Modules\Member\Console\SendDailyUpdates;
use Coeliac\Modules\Shop\Console\ApplyMassDiscounts;
use Coeliac\Base\Console\Commands\ClearPublicDirectories;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Coeliac\Modules\Recipe\Console\PrefixRecipesWithGlutenFree;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ApplyMassDiscounts::class,
        ClearPublicDirectories::class,
        CloseBaskets::class,
//        ImportCommand::class,
        PrefixRecipesWithGlutenFree::class,
        SendDailyUpdates::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('coeliac:shopCloseBaskets')->everyMinute();
        $schedule->command('coeliac:apply_mass_discounts')->everyMinute();
        $schedule->command('coeliac:clear_public_dirs')->daily();

        $schedule->command('list')->thenPing('http://beats.envoyer.io/heartbeat/8YWokjIDBE2Dkzc');

        $schedule->command('backup:clean')->dailyAt('0:00');
        $schedule->command('backup:run')->dailyAt('00:30');

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
        $schedule->command('mailcoach:cleanup-processed-feedback')->hourly();
    }
}
