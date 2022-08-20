<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\Feed\RecipeFeed;
use Coeliac\Modules\Recipe\Repository;
use Illuminate\Http\Response;

class RecipeFeedController extends BaseController
{
    public function list(Repository $repository, RecipeFeed $feed): Response
    {
        return new Response(
            $feed->render($repository->take(10)),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
