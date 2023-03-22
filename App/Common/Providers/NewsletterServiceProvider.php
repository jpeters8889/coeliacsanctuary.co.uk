<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Common\Mailcoach\Components\AddBlock;
use Coeliac\Common\Mailcoach\Components\AddComponent;
use Coeliac\Common\Mailcoach\Components\Editable\Title as EditorTitle;
use Coeliac\Common\Mailcoach\Components\Compiled\Title as CompiledTitle;
use Coeliac\Common\Mailcoach\Components\Editable\Text as EditorText;
use Coeliac\Common\Mailcoach\Components\Compiled\Text as CompiledText;
use Coeliac\Common\Mailcoach\Components\Editable\Hr as EditorHr;
use Coeliac\Common\Mailcoach\Components\Compiled\Hr as CompiledHr;
use Coeliac\Common\Mailcoach\Components\Editable\Image as EditorImage;
use Coeliac\Common\Mailcoach\Components\Compiled\Image as CompiledImage;
use Coeliac\Common\Mailcoach\Components\Editable\Subtitle as EditorSubtitle;
use Coeliac\Common\Mailcoach\Components\Compiled\Subtitle as CompiledSubtitle;
use Coeliac\Common\Mailcoach\Components\Editable\Blog as EditorBlog;
use Coeliac\Common\Mailcoach\Components\Compiled\Blog as CompiledBlog;
use Coeliac\Common\Mailcoach\Components\Editable\Recipe as EditorRecipe;
use Coeliac\Common\Mailcoach\Components\Compiled\Recipe as CompiledRecipe;
use Coeliac\Common\Mailcoach\Components\Editable\Product as EditorProduct;
use Coeliac\Common\Mailcoach\Components\Compiled\Product as CompiledProduct;
use Coeliac\Common\Mailcoach\Components\Editable\Eatery as EditorEatery;
use Coeliac\Common\Mailcoach\Components\Compiled\Eatery as CompiledEatery;
use Coeliac\Common\Mailcoach\Components\Editable\Button as EditorButton;
use Coeliac\Common\Mailcoach\Components\Compiled\Button as CompiledButton;
use Coeliac\Common\Mailcoach\Components\Editable\TextWithButton as EditorTextWithButton;
use Coeliac\Common\Mailcoach\Components\Compiled\TextWithButton as CompiledTextWithButton;
use Coeliac\Common\Mailcoach\Components\Editable\ImageWithButton as EditorImageWithButton;
use Coeliac\Common\Mailcoach\Components\Compiled\ImageWithButton as CompiledImageWithButton;
use Coeliac\Common\Mailcoach\Components\MainEditor;
use Coeliac\Common\Mailcoach\Editor;
use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Services\Mailcoach;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class NewsletterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @phpstan-ignore-next-line  */
        Route::mailcoach('mailcoach');
        /** @phpstan-ignore-next-line  */
        Route::sesFeedback('ses-feedback');

        Gate::define('viewMailcoach', fn (User $user) => in_array($user->email, [
            'jamie@jamie-peters.co.uk', 'contact@coeliacsanctuary.co.uk',
        ]));

        Livewire::component('coeliac-editor', Editor::class);

        Livewire::component('coeliac-newsletter-main-editor', MainEditor::class);
        Livewire::component('coeliac-newsletter-add-block', AddBlock::class);
        Livewire::component('coeliac-newsletter-add-component', AddComponent::class);

        Livewire::component('coeliac-newsletter-editor-component-title', EditorTitle::class);
        Livewire::component('coeliac-newsletter-compiled-component-title', CompiledTitle::class);

        Livewire::component('coeliac-newsletter-editor-component-subtitle', EditorSubtitle::class);
        Livewire::component('coeliac-newsletter-compiled-component-subtitle', CompiledSubtitle::class);

        Livewire::component('coeliac-newsletter-editor-component-text', EditorText::class);
        Livewire::component('coeliac-newsletter-compiled-component-text', CompiledText::class);

        Livewire::component('coeliac-newsletter-editor-component-hr', EditorHr::class);
        Livewire::component('coeliac-newsletter-compiled-component-hr', CompiledHr::class);

        Livewire::component('coeliac-newsletter-editor-component-image', EditorImage::class);
        Livewire::component('coeliac-newsletter-compiled-component-image', CompiledImage::class);

        Livewire::component('coeliac-newsletter-editor-component-blog', EditorBlog::class);
        Livewire::component('coeliac-newsletter-compiled-component-blog', CompiledBlog::class);

        Livewire::component('coeliac-newsletter-editor-component-recipe', EditorRecipe::class);
        Livewire::component('coeliac-newsletter-compiled-component-recipe', CompiledRecipe::class);

        Livewire::component('coeliac-newsletter-editor-component-product', EditorProduct::class);
        Livewire::component('coeliac-newsletter-compiled-component-product', CompiledProduct::class);

        Livewire::component('coeliac-newsletter-editor-component-eatery', EditorEatery::class);
        Livewire::component('coeliac-newsletter-compiled-component-eatery', CompiledEatery::class);

        Livewire::component('coeliac-newsletter-editor-component-button', EditorButton::class);
        Livewire::component('coeliac-newsletter-compiled-component-button', CompiledButton::class);

        Livewire::component('coeliac-newsletter-editor-component-text-with-button', EditorTextWithButton::class);
        Livewire::component('coeliac-newsletter-compiled-component-text-with-button', CompiledTextWithButton::class);

        Livewire::component('coeliac-newsletter-editor-component-image-with-button', EditorImageWithButton::class);
        Livewire::component('coeliac-newsletter-compiled-component-image-with-button', CompiledImageWithButton::class);

        $this->app->bind(
            NewsletterService::class,
            fn () => new Mailcoach(
                Container::getInstance()
                    ->make(Repository::class)
                    ->get('coeliac.newsletter.list')
            )
        );
    }
}
