<?php

declare(strict_types=1);

namespace Coeliac\Common\Feed;

use Coeliac\Common\Rss\AbstractRssFeed;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Model;

class CombinedFeed extends AbstractRssFeed
{
    protected function formatItem(Model $item): array
    {
        /** @var $item Blog | Recipe | Review */

        return [
            'title' => [
                'cdata' => true,
                'value' => $item->title,
            ],
            'link' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$item->link,
            ],
            'guid' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$item->link,
            ],
            'description' => [
                'cdata' => true,
                'value' => $item->meta_description,
            ],
            'author' => [
                'value' => 'contact@coeliacsanctuary.co.uk (Coeliac Sanctuary)',
            ],
            'comments' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$item->link.'#comments',
            ],
            'enclosure' => [
                'value' => '',
                'short' => true,
                'params' => [
                    'url' => $item->main_image,
                    'type' => 'image/*',
                ],
            ],
            'pubData' => [
                'value' => $item->created_at->toRfc822String(),
            ],
        ];
    }

    protected function feedTitle(): string
    {
        return 'Coeliac Sanctuary RSS Feed';
    }

    protected function feedDescription(): string
    {
        return 'Blogs, Reviews and Recipes from CoeliacSanctuary.co.uk';
    }

    protected function linkRoot(): string
    {
        return '';
    }
}
