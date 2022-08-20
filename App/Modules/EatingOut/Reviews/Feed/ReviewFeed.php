<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Feed;

use Coeliac\Common\Rss\AbstractRssFeed;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Model;

class ReviewFeed extends AbstractRssFeed
{
    protected function formatItem(Model $item): array
    {
        /* @var Review $review */
        $review = $item;

        return [
            'title' => [
                'cdata' => true,
                'value' => $review->title,
            ],
            'link' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$review->link,
            ],
            'guid' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$review->link,
            ],
            'description' => [
                'cdata' => true,
                'value' => $review->meta_description,
            ],
            'author' => [
                'value' => 'contact@coeliacsanctuary.co.uk (Coeliac Sanctuary)',
            ],
            'comments' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$review->link.'#comments',
            ],
            'enclosure' => [
                'value' => '',
                'short' => true,
                'params' => [
                    'url' => $review->main_image,
                    'type' => 'image/*',
                ],
            ],
            'pubData' => [
                'value' => $review->created_at->toRfc822String(),
            ],
        ];
    }

    protected function feedTitle(): string
    {
        return 'Coeliac Sanctuary Review RSS Feed';
    }

    protected function linkRoot(): string
    {
        return 'review';
    }

    protected function feedDescription(): string
    {
        return 'Gluten Free Reviews from CoeliacSanctuary.co.uk';
    }
}
