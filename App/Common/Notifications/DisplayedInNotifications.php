<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;

/** @mixin AbstractRepository<Blog> */
trait DisplayedInNotifications
{
    /** @return Collection<int, array{id: mixed, title: string, link: string, image: string|null}> */
    public static function forEmail(): Collection
    {
        $items = (new self())
            ->setWiths([])
            ->setColumns(['id'])
            ->random()
            ->take(3)
            ->pluck('id')
            ->toArray();

        return (new self())
            ->fromIds($items)
            ->map(fn (Blog $item) => [ //@phpstan-ignore-line
                'id' => $item->id,
                'title' => $item->title,
                'link' => Container::getInstance()->make(ConfigRepository::class)->get('app.url').$item->link,
                'image' => $item->main_image,
            ]);
    }
}
