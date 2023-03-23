<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Livewire\Component;

class Hr extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.hr');
    }
}
