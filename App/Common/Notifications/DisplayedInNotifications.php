<?php

namespace Coeliac\Common\Notifications;

use Coeliac\Common\Repositories\AbstractRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

/** @mixin AbstractRepository */
trait DisplayedInNotifications
{
    public static function forEmail()
    {
        $items = (new static())
            ->setWiths([])
            ->setColumns(['id'])
            ->random()
            ->take(3)
            ->pluck('id')
            ->toArray();

        return (new static())
            ->fromIds($items)
            ->transform(static function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'link' => Container::getInstance()->make(ConfigRepository::class)->get('app.url').$item->link,
                    'image' => $item->main_image,
                ];
            });
    }
}
