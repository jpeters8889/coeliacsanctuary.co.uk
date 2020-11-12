<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Services\SiteMapService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Response;

class SiteMapController extends BaseController
{
    public function get(ViewFactory $viewFactory, SiteMapService $service)
    {
        return new Response(
            $viewFactory->make('static.sitemap', [
                'blogs' => $service->blogs(),
                'recipes' => $service->recipes(),
                'counties' => $service->counties(),
                'towns' => $service->towns(),
                'reviews' => $service->reviews(),
            ])->render(),
            200,
            ['Content-type' => 'application/xml']
        );
    }
}
