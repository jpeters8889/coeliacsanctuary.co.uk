<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\DTOs\RecipeRelationCount;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;
use Coeliac\Modules\Recipe\Repository;
use Illuminate\Support\Collection;

class RecipeAllergensController extends BaseController
{
    public function __construct(private Repository $repository)
    {
    }

    public function list(): array
    {
        /** @var Collection<int,RecipeRelationCount> $allergens */
        $allergens = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->load('allergens')
            ->each(fn (Recipe $recipe) => $recipe->allergens->each(function (RecipeAllergen $allergen) use ($recipe, &$allergens) {
                if ($allergens->where('id', $allergen->id)->count() > 0) {
                    $allergens->firstWhere('id', $allergen->id)->recipes->push($recipe->id);

                    return;
                }

                $allergens->push(new RecipeRelationCount([
                    'id' => $allergen->id,
                    'title' => $allergen->allergen,
                    'recipes' => new Collection([$recipe->id]),
                ]));
            }));

        return [
            'data' => $allergens->map(fn (RecipeRelationCount $allergen) => [
                'title' => $allergen->title,
                'recipes_count' => $allergen->recipes->count(),
            ])->sortByDesc('recipes_count')->values(),
        ];
    }
}
