<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Livewire\Component;

class Button extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public string $label;

    public string $link;

    public function mount()
    {
        $this->label = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function hydrate()
    {
        $this->label = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.button');
    }

    public function updatedLabel()
    {
        $this->properties['content'] = $this->label;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedLink()
    {
        $this->properties['link'] = $this->link;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }
}
