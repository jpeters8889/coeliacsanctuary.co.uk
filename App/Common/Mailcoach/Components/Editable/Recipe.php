<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Coeliac\Modules\Recipe\Models\Recipe as RecipeModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Recipe extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public ?int $recipeId = null;

    public string $search = '';

    public Collection $results;

    public ?RecipeModel $recipe = null;

    public function mount()
    {
        $this->recipeId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
        }
    }

    public function hydrate()
    {
        $this->recipeId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->recipeId) {
            $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.recipe');
    }

    public function updatedRecipe()
    {
        $this->properties['content'] = $this->recipeId;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedSearch()
    {
        $this->results = RecipeModel::query()
            ->with(['images'])
            ->where('live', true)
            ->where(
                fn (Builder $builder) => $builder
                ->where('id', $this->search)
                ->orWhere('title', 'LIKE', "%{$this->search}%")
            )
            ->latest()
            ->take(10)
            ->get();
    }

    public function selectRecipe($id)
    {
        $this->recipeId = $id;
        $this->recipe = RecipeModel::query()->where('live', true)->find($this->recipeId);
        $this->results = new Collection();
        $this->search = '';
        $this->updatedRecipe();
    }
}
