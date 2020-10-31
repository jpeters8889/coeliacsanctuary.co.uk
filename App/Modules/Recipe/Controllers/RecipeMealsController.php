<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Illuminate\Support\Collection;
use Coeliac\Modules\Recipe\Repository;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\Models\RecipeMeal;

class RecipeMealsController extends BaseController
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        $meals = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->each(function (Recipe $recipe) use (&$meals) {
                $recipe->meals->each(function (RecipeMeal $meal) use ($recipe, &$meals) {
                    if (isset($meals[$meal->id])) {
                        $meals[$meal->id]['recipes']->push($recipe->id);

                        return;
                    }

                    $meals[$meal->id] = new Collection([
                        'title' => $meal->meal,
                        'recipes' => new Collection([$recipe->id]),
                    ]);
                });
            });

        return [
            'data' => $meals->map(static function ($meal) {
                return [
                    'title' => $meal['title'],
                    'recipes_count' => $meal['recipes']->count(),
                ];
            })->sortByDesc('recipes_count')
                ->values(),
        ];
    }
}
