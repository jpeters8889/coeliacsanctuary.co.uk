<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Livewire\Component;

class Product extends Component
{
    public array $properties;

    public ?int $productId = null;

    public string $description;

    public ShopProduct $product;

    public string $block;

    public int $position;

    public function mount()
    {
        $this->productId = $this->properties['content'] ?? null;

        if ($this->productId) {
            $this->product = ShopProduct::withLiveProducts()->find($this->productId);
            $this->description = $this->block === 'single' ? $this->product->description : $this->product->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
        }
    }

    public function hydrate()
    {
        $this->productId = $this->properties['content'] ?? null;

        if ($this->productId) {
            $this->product = ShopProduct::withLiveProducts()->find($this->productId);
            $this->description = $this->block === 'single' ? $this->product->description : $this->product->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.product');
    }
}
