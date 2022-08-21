<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Recipe\DTOs\RecipeRelationCount;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Repository;
use Illuminate\Support\Collection;

class RecipeFeaturesController extends BaseController
{
    public function __construct(private Repository $repository)
    {
    }

    public function list(): array
    {
        /** @var Collection<int,RecipeRelationCount> $features */
        $features = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->load('features')
            ->each(fn (Recipe $recipe) => $recipe->features->each(function (RecipeFeature $feature) use ($recipe, &$features) {
                if ($features->where('id', $feature->id)->count() > 0) {
                    $features->firstWhere('id', $feature->id)->recipes->push($recipe->id);

                    return;
                }

                $features->push(new RecipeRelationCount([
                    'id' => $feature->id,
                    'title' => $feature->feature,
                    'recipes' => new Collection([$recipe->id]),
                ]));
            }));

        return [
            'data' => $features->map(fn ($feature) => [
                'title' => $feature->title,
                'recipes_count' => $feature->recipes->count(),
            ])->sortByDesc('recipes_count')->values(),
        ];
    }
}
