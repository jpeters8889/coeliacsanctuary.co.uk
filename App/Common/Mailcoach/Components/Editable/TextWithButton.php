<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Livewire\Component;

class TextWithButton extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public string $content;

    public string $label;

    public string $link;

    public function mount()
    {
        $this->content = isset($this->properties['content']) ? implode("\n", $this->properties['content']) : '';
        $this->label = $this->properties['label'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function hydrate()
    {
        $this->content = isset($this->properties['content']) ? implode("\n", $this->properties['content']) : '';
        $this->label = $this->properties['label'] ?? '';
        $this->link = $this->properties['link'] ?? '';
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.text-with-button');
    }

    public function updatedContent()
    {
        $this->properties['content'] = explode("\n", $this->content);

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedLabel()
    {
        $this->properties['label'] = $this->label;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedLink()
    {
        $this->properties['link'] = $this->link;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }
}
