<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Livewire\Component;

class Text extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public string $content = '';

    public function mount()
    {
        $this->content = isset($this->properties['content']) ? implode("\n", $this->properties['content']) : '';
    }

    public function hydrate()
    {
        $this->content = isset($this->properties['content']) ? implode("\n", $this->properties['content']) : '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.text');
    }

    public function updatedContent()
    {
        $this->properties['content'] = explode("\n", $this->content);

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }
}
