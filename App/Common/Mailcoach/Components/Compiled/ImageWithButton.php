<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class ImageWithButton extends Component
{
    public array $properties;

    public string $image;

    public string $label;

    public string $link;

    public string $block;

    public function mount()
    {
        $this->image = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
        $this->label = $this->properties['label'] ?? '';
    }

    public function hydrate()
    {
        $this->image = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
        $this->label = $this->properties['label'] ?? '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.image-with-button');
    }
}
