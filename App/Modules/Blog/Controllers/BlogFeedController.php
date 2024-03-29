<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\Feed\BlogFeed;
use Coeliac\Modules\Blog\Repository;
use Illuminate\Http\Response;

class BlogFeedController extends BaseController
{
    public function list(Repository $repository, BlogFeed $feed): Response
    {
        return new Response(
            $feed->render($repository->setColumns(['id', 'title', 'slug', 'meta_description', 'created_at'])->take(10)),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
