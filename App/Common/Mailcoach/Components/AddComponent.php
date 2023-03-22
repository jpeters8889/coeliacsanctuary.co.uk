<?php

namespace Coeliac\Common\Mailcoach\Components;

use Livewire\Component;

class AddComponent extends Component
{
    public string $blockId;

    public int $index;

    protected $listeners = ['addComponent'];

    public function render()
    {
        return view('mailcoach.components.add-component');
    }

    public function toggleModal()
    {
        $this->emit('toggle-component-modal');
    }

    public function addComponent($blockId, $component, $index)
    {
        if ($blockId !== $this->blockId && $index !== $this->index) {
            return;
        }

        $this->emit('addComponentToBlock', $blockId, $component, $index);
    }
}
