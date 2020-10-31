<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Coeliac\Modules\EatingOut\Reviews\Feed\ReviewFeed;

class ReviewFeedController extends BaseController
{
    public function list(Repository $repository, ReviewFeed $feed)
    {
        return new Response(
            $feed->render($repository->all()),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
