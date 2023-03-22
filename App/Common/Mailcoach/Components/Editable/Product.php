<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Product extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public ?int $productId = null;

    public string $search = '';

    public Collection $results;

    public ShopProduct $product;

    public function mount()
    {
        $this->productId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->productId) {
            $this->product = ShopProduct::withLiveProducts()->find($this->productId);
        }
    }

    public function hydrate()
    {
        $this->productId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->productId) {
            $this->product = ShopProduct::withLiveProducts()->find($this->productId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.product');
    }

    public function updatedProduct()
    {
        $this->properties['content'] = $this->productId;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedSearch()
    {
        $this->results = ShopProduct::withLiveProducts()
            ->with(['images', 'variants', 'prices'])
            ->where(
                fn (Builder $builder) => $builder
                ->where('id', $this->search)
                ->orWhere('title', 'LIKE', "%{$this->search}%")
            )
            ->latest()
            ->take(10)
            ->get();
    }

    public function selectProduct($id)
    {
        $this->productId = $id;
        $this->product = ShopProduct::withLiveProducts()->find($this->productId);
        $this->results = new Collection();
        $this->search = '';
        $this->updatedProduct();
    }
}
