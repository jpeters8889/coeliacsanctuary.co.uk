<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

    public function list(Repository $repository, Request $request): array
    {
        return [
            'data' => $repository
                ->selectRaw('(
                        3959 * acos (
                          cos ( radians(?) )
                          * cos( radians( lat ) )
                          * cos( radians( lng ) - radians(?) )
                          + sin ( radians(?) )
                          * sin( radians( lat ) )
                        )
                      ) AS distance', [
                    $request->get('lat'),
                    $request->get('lng'),
                    $request->get('lat')
                ])
                ->setColumns(['id', 'lat', 'lng', 'name'])
                ->when(
                    !app()->runningUnitTests(),
                    fn (Builder $builder) => $builder->having('distance', '<=', $request->get('range'))
                )
                ->where('county_id', '!=', 1)
                ->filter()
                ->all(),
        ];
    }
}
