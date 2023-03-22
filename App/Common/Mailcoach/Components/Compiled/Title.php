<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class Title extends Component
{
    public array $properties;

    public string $title;

    public ?string $link = null;

    public function mount()
    {
        $this->title = $this->properties['content'] ?? '';

        if(isset($this->properties['link'])) {
            $this->link = $this->properties['link'];
        }
    }

    public function hydrate()
    {
        $this->title = $this->properties['content'] ?? '';

        if(isset($this->properties['link'])) {
            $this->link = $this->properties['link'];
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.title');
    }
}
