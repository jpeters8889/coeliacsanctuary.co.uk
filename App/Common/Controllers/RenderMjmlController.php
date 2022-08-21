<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Requests\NewsletterRenderRequest;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\View\Factory as ViewFactory;

class RenderMjmlController extends BaseController
{
    public function get(NewsletterRenderRequest $request, ViewFactory $viewFactory, CompilerContract $compiler): string|HtmlString
    {
        $compiled = $compiler->compile(
            $viewFactory->make('mailables.mjml.newsletter-template', [
                'introLines' => (new Collection(explode("\n", $request->input('introText'))))
                    ->filter()
                    ->values(),
                'recipes' => Recipe::query()->with('images')->whereIn('id', $request->input('recipes'))->get()
                    ->sortBy(fn ($model) => array_search($model->getKey(), $request->input('recipes'))),
                'blogs' => Blog::query()->with('images')->whereIn('id', $request->input('blogs'))->get()
                    ->sortBy(fn ($model) => array_search($model->getKey(), $request->input('blogs'))),
//                'reviews' => Review::query()->whereIn('id', $request->input('reviews'))->get()
//                    ->sortBy(fn ($model) => array_search($model->getKey(), $request->input('reviews'))),
                'eateries' => WhereToEat::query()
                    ->with(['country', 'county', 'town'])
                    ->where('type_id', 1)
                    ->where('live', true)
                    ->take(3)
                    ->inRandomOrder()
                    ->get(),
            ])->render()
        );

        return $compiled['html'];
    }
}
