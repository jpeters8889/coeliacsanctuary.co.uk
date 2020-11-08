<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications\Channels;

use Coeliac\Common\Models\User;
use Illuminate\Container\Container;
use Illuminate\Notifications\Notification;
use Illuminate\View\Factory as ViewFactory;
use Coeliac\Common\Models\NotificationEmail;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Illuminate\Notifications\AnonymousNotifiable;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Notifications\Channels\MailChannel as NotificationChannel;

class MailChannel extends NotificationChannel
{
    public function send($notifiable, Notification $notification)
    {
        /** @var \Coeliac\Common\Notifications\Notification $notification */
        $email = '';

        if ($notifiable instanceof User) {
            $email = $notifiable->email;
        }

        if ($notifiable instanceof AnonymousNotifiable) {
            $email = $notifiable->routes['mail'] ?? '';
        }

        /** @var MJMLMessage $message */
        $message = $notification->toMail($notifiable);

        $model = NotificationEmail::query()->create([
            'user_id' => $notifiable->id ?? null,
            'email_address' => $email,
            'template' => $message->mjml,
            'data' => $message->viewData,
        ]);

        $notification->setKey($model->key);

        parent::send($notifiable, $notification);
    }

    protected function buildMjml(MJMLMessage $message)
    {
        $view = Container::getInstance()->make(ViewFactory::class);
        $compiler = Container::getInstance()->make(CompilerContract::class);

        $rawMessage = $view->make($message->mjml, $message->data())->render();

        return $compiler->compile($rawMessage);
    }

    /**
     * @param MJMLMessage $message
     *
     * @return array|string
     */
    protected function buildView($message)
    {
        if ($message->mjml) {
            return $this->buildMjml($message);
        }

        return parent::buildView($message);
    }
}
