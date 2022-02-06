<?php

declare(strict_types=1);

namespace Coeliac\Common\Mailcoach;

use Illuminate\View\Factory;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Spatie\Mailcoach\Domain\Campaign\Models\Concerns\HasHtmlContent;
use Spatie\Mailcoach\Domain\Shared\Support\Editor\Editor as MailcoachEditor;

class Editor implements MailcoachEditor
{
    public function render(HasHtmlContent $model): string
    {
        $data = null;
        $introText = '';
        $recipes = [null, null, null];
        $blogs = [null, null];
//        $reviews = [null, null];

        if ($model->getStructuredHtml()) {
            $data = json_decode((string) $model->getStructuredHtml(), true);

            $introText = $data['introText'];
            $recipes = Recipe::query()->whereIn('id', $data['recipes'])->get();
            $blogs = Blog::query()->whereIn('id', $data['blogs'])->get();
//            $reviews = Review::query()->whereIn('id', $data['reviews'])->get();
        }

        return Container::getInstance()->make(Factory::class)
            ->make('mailcoach.editor', [
                'data' => $model->getStructuredHtml() ? "'{$model->getStructuredHtml()}'" : '',
                'html' => $model->getHtml() ? "'{$model->getHtml()}'" : null,
                'introText' => $introText,
                'recipes' => $recipes,
                'blogs' => $blogs,
//                'reviews' => $reviews,
            ])
            ->render();
    }
}
