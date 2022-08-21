<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\DTOs\RecipeRelationCount;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Repository;
use Illuminate\Support\Collection;

class RecipeMealsController extends BaseController
{
    public function __construct(protected Repository $repository)
    {
    }

    public function list(): array
    {
        /** @var Collection<int,RecipeRelationCount> $meals */
        $meals = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->load('meals')
            ->each(fn (Recipe $recipe) => $recipe->meals->each(function (RecipeMeal $meal) use ($recipe, &$meals) {
                if ($meals->where('id', $meal->id)->count() > 0) {
                    $meals->firstWhere('id', $meal->id)->recipes->push($recipe->id);

                    return;
                }

                $meals->push(new RecipeRelationCount([
                    'id' => $meal->id,
                    'title' => $meal->meal,
                    'recipes' => new Collection([$recipe->id]),
                ]));
            }));

        return [
            'data' => $meals->map(fn (RecipeRelationCount $meal) => [
                'title' => $meal->title,
                'recipes_count' => $meal->recipes->count(),
            ])->sortByDesc('recipes_count')->values(),
        ];
    }
}
