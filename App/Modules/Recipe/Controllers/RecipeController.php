<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Repository;
use Coeliac\Modules\Recipe\Requests\RecipeShowRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecipeController extends BaseController
{
    public function __construct(private Page $page, private Repository $repository)
    {
    }

    public function index(): Response
    {
        return $this->page
            ->breadcrumbs([], 'Recipes')
            ->setPageTitle('Gluten Free Recipes')
            ->setMetaDescription('Coeliac Sanctuary gluten free recipe list, all of our fabulous gluten free recipes which have been tried and tested by us')
            ->setMetaKeywords(['coeliac sanctuary recipes', 'recipe index', 'index', 'recipe list', 'gluten free recipes', 'recipes', 'coeliac recipes'])
            ->setSocialImage(asset('assets/images/shares/recipe-list.jpg'))
            ->render('modules.recipes.index');
    }

    public function list(Request $request): array
    {
        $this->validate($request, [
            'limit' => 'integer,max:50',
        ]);

        return [
            'data' => $this->repository
                ->setWithCounts(['comments'])
                ->setWiths(['nutrition', 'features', 'images', 'images.image'])
                ->setColumns(['id', 'title', 'slug', 'description', 'meta_description', 'created_at', 'serving_size', 'per'])
                ->filter()
                ->search()
                ->paginated($request->get('limit', 12)),
        ];
    }

    public function show(RecipeShowRequest $request): Response
    {
        /* @var Recipe $recipe */
        abort_if(! $recipe = $request->resolveItem(), 404, 'Sorry, this recipe can\'t be found');

        $featured = null;

        if ($recipe->associatedCollections()->count() > 0) {
            $featured = $recipe->associatedCollections()
                ->inRandomOrder()
                ->take(3)
                ->get()
                ->transform(fn (CollectionItem $item) => $item->collection);
        }

        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/recipe',
                    'title' => 'Recipes',
                ],
            ], $recipe->title)
            ->scrapable('recipe', $recipe->id)
            ->setPageTitle($recipe->title.' | Recipes')
            ->setMetaDescription($recipe->meta_description)
            ->setMetaKeywords(explode(',', (string) $recipe->meta_keywords))
            ->setSocialImage($recipe->social_image)
            ->render('modules.recipes.show', compact('recipe', 'featured'));
    }

    public function print(RecipeShowRequest $request): Response
    {
        /* @var Recipe $recipe */
        abort_if(! $recipe = $request->resolveItem(), 404, 'Sorry, this recipe can\'t be found');

        return $this->page->render('modules.recipes.print', compact('recipe'));
    }
}
