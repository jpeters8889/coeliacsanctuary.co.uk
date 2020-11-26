<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Illuminate\Http\Response;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Feed\BlogFeed;
use Coeliac\Base\Controllers\BaseController;

class BlogFeedController extends BaseController
{
    public function list(Repository $repository, BlogFeed $feed)
    {
        return new Response(
            $feed->render($repository->setColumns(['id', 'title', 'slug', 'meta_description', 'created_at'])->all()),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
