<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Livewire\Component;

class Eatery extends Component
{
    public array $properties;

    public ?int $eateryId = null;

    public WhereToEat $eatery;

    public string $block;

    public function mount()
    {
        $this->eateryId = $this->properties['content'] ?? null;

        if ($this->eateryId) {
            $this->eatery = WhereToEat::query()
                ->with(['town', 'county', 'country', 'userReviews'])
                ->where('live', true)
                ->find($this->eateryId);
        }
    }

    public function hydrate()
    {
        $this->eateryId = $this->properties['content'] ?? null;

        if ($this->eateryId) {
            $this->eatery = WhereToEat::query()
                ->with(['town', 'county', 'country', 'userReviews'])
                ->where('live', true)
                ->find($this->eateryId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.eatery');
    }
}
