<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class Image extends Component
{
    public array $properties;

    public string $image;

    public string $link;

    public function mount()
    {
        $this->image = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function hydrate()
    {
        $this->image = $this->properties['content'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.image');
    }
}
