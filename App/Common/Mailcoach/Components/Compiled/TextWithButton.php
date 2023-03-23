<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class TextWithButton extends Component
{
    public array $properties;

    public array $content = [];

    public string $label;

    public string $link;

    public string $block;

    public function mount()
    {
        $this->content = $this->properties['content'] ?? [];
        $this->label = $this->properties['label'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function hydrate()
    {
        $this->content = $this->properties['content'] ?? [];
        $this->label = $this->properties['label'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.text-with-button');
    }
}
