<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Livewire\Component;

class Hr extends Component
{
    public array $properties;

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.hr');
    }
}
