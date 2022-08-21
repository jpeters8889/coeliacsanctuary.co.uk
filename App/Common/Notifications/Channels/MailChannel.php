<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications\Channels;

use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Models\NotificationEmail;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Channels\MailChannel as NotificationChannel;
use Illuminate\Notifications\Notification;
use Illuminate\View\Factory as ViewFactory;

class MailChannel extends NotificationChannel
{
    public function send($notifiable, Notification $notification)
    {
        /**
         * @var MJMLMessage $message
         * @phpstan-ignore-next-line
         */
        $message = $notification->toMail($notifiable);

        if (! isset($message->mjml)) {
            parent::send($notifiable, $notification);

            return;
        }

        /** @var \Coeliac\Common\Notifications\Notification $notification */
        $email = '';

        if ($notifiable instanceof User) {
            $email = $notifiable->email;
        }

        if ($notifiable instanceof AnonymousNotifiable) {
            $email = $notifiable->routes['mail'] ?? '';
        }

        $model = NotificationEmail::query()->create([
            'user_id' => $notifiable->id ?? null,
            'email_address' => $email,
            'template' => $message->mjml,
            'data' => $message->viewData,
        ]);

        $notification->setKey($model->key);

        parent::send($notifiable, $notification);
    }

    protected function buildMjml(MJMLMessage $message): mixed
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
        if (property_exists($message, 'mjml')) {
            return $this->buildMjml($message);
        }

        return parent::buildView($message);
    }
}
