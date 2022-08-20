<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Feed;

use Coeliac\Common\Rss\AbstractRssFeed;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Model;

class BlogFeed extends AbstractRssFeed
{
    protected function formatItem(Model $item): array
    {
        /* @var Blog $blog */
        $blog = $item;

        return [
            'title' => [
                'cdata' => true,
                'value' => $blog->title,
            ],
            'link' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$blog->link,
            ],
            'guid' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$blog->link,
            ],
            'description' => [
                'cdata' => true,
                'value' => $blog->meta_description,
            ],
            'author' => [
                'value' => 'contact@coeliacsanctuary.co.uk (Coeliac Sanctuary)',
            ],
            'comments' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$blog->link.'#comments',
            ],
            'enclosure' => [
                'value' => '',
                'short' => true,
                'params' => [
                    'url' => $blog->main_image,
                    'type' => 'image/*',
                ],
            ],
            'pubData' => [
                'value' => $blog->created_at->toRfc822String(),
            ],
        ];
    }

    protected function feedTitle(): string
    {
        return 'Coeliac Sanctuary Blog RSS Feed';
    }

    protected function linkRoot(): string
    {
        return 'blog';
    }

    protected function feedDescription(): string
    {
        return 'Blog posts from CoeliacSanctuary.co.uk';
    }
}
