<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Eatery extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public ?int $eateryId = null;

    public string $search = '';

    public Collection $results;

    public WhereToEat $eatery;

    public function mount()
    {
        $this->eateryId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->eateryId) {
            $this->eatery = WhereToEat::query()
                ->where('live', true)
                ->with(['town', 'county', 'country'])
                ->find($this->eateryId);
        }
    }

    public function hydrate()
    {
        $this->eateryId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->eateryId) {
            $this->eatery = WhereToEat::query()
                ->where('live', true)
                ->with(['town', 'county', 'country'])
                ->find($this->eateryId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.eatery');
    }

    public function updatedEatery()
    {
        $this->properties['content'] = $this->eateryId;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedSearch()
    {
        $this->results = WhereToEat::query()
            ->with(['town', 'county', 'country'])
            ->where('live', true)
            ->where(
                fn (Builder $builder) => $builder
                ->where('wheretoeat.id', $this->search)
                ->orWhere('name', 'LIKE', "%{$this->search}%")
                ->orWhereRaw('(select wt.town as wheretoeat_town from wheretoeat_towns wt where wt.id = wheretoeat.town_id) LIKE ?', ["%{$this->search}%"])
            )
            ->where('type_id', 1)
            ->latest('wheretoeat.created_at')
            ->take(10)
            ->get();
    }

    public function randomEatery()
    {
        $this->eatery = WhereToEat::query()
            ->where('live', true)
            ->where('type_id', 1)
            ->inRandomOrder()
            ->first();

        $this->eateryId = $this->eatery->id;

        $this->results = new Collection();
        $this->search = '';
        $this->updatedEatery();
    }

    public function selectEatery($id)
    {
        $this->eateryId = $id;
        $this->eatery = WhereToEat::query()->where('live', true)->find($this->eateryId);
        $this->results = new Collection();
        $this->search = '';
        $this->updatedEatery();
    }
}
