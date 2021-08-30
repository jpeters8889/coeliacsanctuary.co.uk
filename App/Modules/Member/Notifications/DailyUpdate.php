<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Services\DailyUpdatePreprocessor;
use Illuminate\Notifications\AnonymousNotifiable;

class DailyUpdate extends Notification
{
    /**
     * @var DailyUpdatePreprocessor
     */
    private DailyUpdatePreprocessor $processor;

    public function __construct(DailyUpdatePreprocessor $processor)
    {
        $this->processor = $processor;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        /** @var User $notifiable */

        return (new MJMLMessage())
            ->subject('Your Daily Update')
            ->mjml('mailables.mjml.member.daily-update', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'updates' => $this->processor->process(),
                'managePreferences' => $notifiable->generateManageDailyUpdatesLink(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
