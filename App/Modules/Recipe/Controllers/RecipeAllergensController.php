<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Illuminate\Support\Collection;
use Coeliac\Modules\Recipe\Repository;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;

class RecipeAllergensController extends BaseController
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        $allergens = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->each(function (Recipe $recipe) use (&$allergens) {
                $recipe->allergens->each(function (RecipeAllergen $allergen) use ($recipe, &$allergens) {
                    if (isset($allergens[$allergen->id])) {
                        $allergens[$allergen->id]['recipes']->push($recipe->id);

                        return;
                    }

                    $allergens[$allergen->id] = new Collection([
                        'title' => $allergen->allergen,
                        'recipes' => new Collection([$recipe->id]),
                    ]);
                });
            });

        return [
            'data' => $allergens->map(static function ($allergen) {
                return [
                    'title' => $allergen['title'],
                    'recipes_count' => $allergen['recipes']->count(),
                ];
            })->sortByDesc('recipes_count')
                ->values(),
        ];
    }
}
