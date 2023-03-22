<?php

namespace Coeliac\Common\Mailcoach\Components;

use Livewire\Component;

class AddBlock extends Component
{
    public function render()
    {
        return view('mailcoach.components.add-block');
    }

    public function toggleModal()
    {
        $this->emit('toggle-modal');
    }

    public function addBlock($block)
    {
        $this->emit('toggle-modal');
        $this->emit('add-block', $block);
    }
}
