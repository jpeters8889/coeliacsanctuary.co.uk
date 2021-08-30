<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\Comments;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('delete', 'coeliac-comments', ApiHandler::class, 'delete');
            $architect->apiManager->registerEndpoint('put', 'coeliac-comments', ApiHandler::class, 'approve');
            $architect->apiManager->registerEndpoint('post', 'coeliac-comments', ApiHandler::class, 'reply');

            $architect->assetManager->registerScript('CommentsCard', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('CommentsCard', __DIR__.'/../dist/card.css');
        });
    }
}
