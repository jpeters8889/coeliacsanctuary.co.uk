<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EateryBrowseProcessor;
use Illuminate\Http\Response;

class WhereToEatBrowseController extends BaseController
{
    public function index(Page $page): Response
    {
        return $page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
                [
                    'link' => '/wheretoeat',
                    'title' => 'Places to Eat',
                ],
            ], 'Browse')
            ->setPageTitle('Browse | Eating Out')
            ->doNotIndex()
            ->render('modules.eating-out.wheretoeat.browse');
    }

    public function list(EateryBrowseProcessor $eateryBrowseProcessor): array
    {
        return [
            'data' => $eateryBrowseProcessor->getEateries()
        ];
    }
}
