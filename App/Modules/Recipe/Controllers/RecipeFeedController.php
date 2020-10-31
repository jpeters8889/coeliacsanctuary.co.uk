<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Illuminate\Http\Response;
use Coeliac\Modules\Recipe\Repository;
use Coeliac\Modules\Recipe\Feed\RecipeFeed;
use Coeliac\Base\Controllers\BaseController;

class RecipeFeedController extends BaseController
{
    public function list(Repository $repository, RecipeFeed $feed)
    {
        return new Response(
            $feed->render($repository->all()),
            200,
            ['Content-type' => 'text/xml']
        );
    }
}
