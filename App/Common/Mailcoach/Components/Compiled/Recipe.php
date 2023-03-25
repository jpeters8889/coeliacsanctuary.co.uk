<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Coeliac\Modules\Recipe\Models\Recipe as RecipeModel;
use Livewire\Component;

class Recipe extends Component
{
    public array $properties;

    public ?int $recipeId = null;

    public ?RecipeModel $recipe = null;

    public $description = '';

    public string $block;

    public int $position;

    public function mount()
    {
        $this->recipeId = $this->properties['content'] ?? null;

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
            $this->description = $this->block === 'single' ? $this->recipe->description : $this->recipe->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
        }
    }

    public function hydrate()
    {
        $this->recipeId = $this->properties['content'] ?? null;

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
            $this->description = $this->block === 'single' ? $this->recipe->description : $this->recipe->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.recipe');
    }
}
