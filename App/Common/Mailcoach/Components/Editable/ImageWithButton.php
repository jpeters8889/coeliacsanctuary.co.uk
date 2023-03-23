<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ImageWithButton extends Component
{
    use WithFileUploads;

    public string $blockId;

    public int $index;

    public array $properties;

    public $image;

    public string $label;

    public string $link;

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.image-with-button');
    }

    public function mount()
    {
        if (isset($this->properties['content'])) {
            $this->image = $this->properties['content'];
            $this->label = $this->properties['label'] ?? '';
            $this->link = $this->properties['link'] ?? '';
        }
    }

    public function hydrate()
    {
        if (isset($this->properties['content'])) {
            $this->image = $this->properties['content'];
            $this->label = $this->properties['label'] ?? '';
            $this->link = $this->properties['link'] ?? '';
        }
    }

    public function updatedImage()
    {
        $upload = $this->image->storeAs("newsletter/{$this->blockId}", $this->image->getFilename(), ['disk' => 'images', 'visibility' => 'public']);

        $this->properties['content'] = Storage::disk('images')->url($upload);

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
