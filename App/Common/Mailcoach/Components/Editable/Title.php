<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Livewire\Component;

class Title extends Component
{
    public string $blockId;

    public int $index;

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
        return view('mailables.mjml.newsletter.components.editor.components.title');
    }

    public function updatedTitle()
    {
        $this->properties['content'] = $this->title;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedLink()
    {
        $this->properties['link'] = $this->link;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }
}
