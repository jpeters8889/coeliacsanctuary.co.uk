<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as IlluminateNotification;

abstract class Notification extends IlluminateNotification implements ShouldQueue
{
    use Queueable;

    protected mixed $key = '';

    protected ?Carbon $date = null;

    public function forceDate(Carbon $date): void
    {
        $this->date = $date;
    }

    public function setKey(mixed $key): static
    {
        $this->key = $key;

        return $this;
    }

    abstract public function toMail(User|AnonymousNotifiable|null $notifiable = null): MailMessage;
}
