<?php

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Requests\NewsletterRenderRequest;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\View\Factory as ViewFactory;

class RenderMjmlController extends BaseController
{
    public function get(NewsletterRenderRequest $request, ViewFactory $viewFactory, CompilerContract $compiler)
    {
        $compiled = $compiler->compile(
            $viewFactory->make('mailables.mjml.newsletter-template', [
                'introLines' => (new Collection(explode("\n", $request->input('introText'))))
                    ->filter()
                    ->values(),
                'recipes' => Recipe::query()->whereIn('id', $request->input('recipes'))->get(),
                'blogs' => Blog::query()->whereIn('id', $request->input('blogs'))->get(),
                'reviews' => Review::query()->whereIn('id', $request->input('reviews'))->get(),
                'eateries' => WhereToEat::query()
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
