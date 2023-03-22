<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Coeliac\Modules\Recipe\Models\Recipe as RecipeModel;
use Livewire\Component;

class Recipe extends Component
{
    public array $properties;

    public ?int $recipeId = null;

    public ?RecipeModel $recipe = null;

    public string $block;

    public function mount()
    {
        $this->recipeId = $this->properties['content'] ?? null;

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
        }
    }

    public function hydrate()
    {
        $this->recipeId = $this->properties['content'] ?? null;

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.recipe');
    }
}
