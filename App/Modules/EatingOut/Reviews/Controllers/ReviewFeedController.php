<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Feed\ReviewFeed;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Illuminate\Http\Response;

class ReviewFeedController extends BaseController
{
    public function list(Repository $repository, ReviewFeed $feed): Response
    {
        return new Response(
            $feed->render($repository->take(10)),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
