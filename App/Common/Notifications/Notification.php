<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as IlluminateNotification;

abstract class Notification extends IlluminateNotification implements ShouldQueue
{
    use Queueable;

    protected $key = '';

    protected ?Carbon $date = null;

    public function forceDate(Carbon $date)
    {
        $this->date = $date;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    abstract public function toMail(User $notifiable = null);
}
