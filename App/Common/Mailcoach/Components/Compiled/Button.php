<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class Button extends Component
{
    public array $properties;

    public string $label;

    public string $link;

    public string $block;

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
        return view('mailables.mjml.newsletter.components.compiled.components.button');
    }
}
