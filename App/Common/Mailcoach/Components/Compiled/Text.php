<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class Text extends Component
{
    public array $properties;

    public array $content = [];

    public function mount()
    {
//        $this->content = $this->properties['content'] ?? [];
    }

    public function hydrate()
    {
//        $this->content = $this->properties['content'] ?? [];
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.text');
    }
}
