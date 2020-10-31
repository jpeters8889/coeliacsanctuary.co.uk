<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Feed;

use Illuminate\Container\Container;
use Coeliac\Common\Rss\AbstractRssFeed;
use Illuminate\Database\Eloquent\Model;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Contracts\Config\Repository;

class RecipeFeed extends AbstractRssFeed
{
    protected function formatItem(Model $item): array
    {
        /* @var Recipe $recipe */
        $recipe = $item;

        return [
            'title' => [
                'cdata' => true,
                'value' => $recipe->title,
            ],
            'link' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$recipe->link,
            ],
            'guid' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$recipe->link,
            ],
            'description' => [
                'cdata' => true,
                'value' => $recipe->meta_description,
            ],
            'author' => [
                'value' => 'contact@coeliacsanctuary.co.uk (Coeliac Sanctuary)',
            ],
            'comments' => [
                'value' => Container::getInstance()->make(Repository::class)->get('app.url').$recipe->link.'#comments',
            ],
            'enclosure' => [
                'value' => '',
                'short' => true,
                'params' => [
                    'url' => $recipe->main_image,
                    'type' => 'image/*',
                ],
            ],
            'pubData' => [
                'value' => $recipe->created_at->toRfc822String(),
            ],
        ];
    }

    protected function feedTitle(): string
    {
        return 'Coeliac Sanctuary Recipe RSS Feed';
    }

    protected function linkRoot(): string
    {
        return 'recipe';
    }

    protected function feedDescription(): string
    {
        return 'Gluten Free Recipes from CoeliacSanctuary.co.uk';
    }
}
