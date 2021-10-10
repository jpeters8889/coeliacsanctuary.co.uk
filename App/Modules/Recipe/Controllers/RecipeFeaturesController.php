<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Illuminate\Support\Collection;
use Coeliac\Modules\Recipe\Repository;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\Models\RecipeFeature;

class RecipeFeaturesController extends BaseController
{
    public function __construct(private Repository $repository)
    {
    }

    public function list(): array
    {
        $features = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->load('features')
            ->each(function (Recipe $recipe) use (&$features) {
                $recipe->features->each(function (RecipeFeature $feature) use ($recipe, &$features) {
                    if (isset($features[$feature->id])) {
                        $features[$feature->id]['recipes']->push($recipe->id);

                        return;
                    }

                    $features[$feature->id] = new Collection([
                        'title' => $feature->feature,
                        'recipes' => new Collection([$recipe->id]),
                    ]);
                });
            });

        return [
            'data' => $features->map(static function ($feature) {
                return [
                    'title' => $feature['title'],
                    'recipes_count' => $feature['recipes']->count(),
                ];
            })->sortByDesc('recipes_count')
                ->values(),
        ];
    }
}
