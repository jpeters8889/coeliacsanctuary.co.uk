<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Coeliac\Modules\Blog\Models\Blog as BlogModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Blog extends Component
{
    public string $blockId;

    public int $index;

    public array $properties;

    public ?int $blogId = null;

    public string $search = '';

    public Collection $results;

    public BlogModel $blog;

    public function mount()
    {
        $this->blogId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->blogId) {
            $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
        }
    }

    public function hydrate()
    {
        $this->blogId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->blogId) {
            $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.editor.components.blog');
    }

    public function updatedBlog()
    {
        $this->properties['content'] = $this->blogId;

        $this->emit('componentUpdated', $this->blockId, $this->index, $this->properties);
    }

    public function updatedSearch()
    {
        $this->results = BlogModel::query()
            ->with(['images'])
            ->where('live', true)
            ->where(
                fn (Builder $builder) => $builder
                ->where('id', $this->search)
                ->orWhere('title', 'LIKE', "%{$this->search}%")
            )
            ->latest()
            ->take(10)
            ->get();
    }

    public function selectBlog($id)
    {
        $this->blogId = $id;
        $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
        $this->results = new Collection();
        $this->search = '';
        $this->updatedBlog();
    }
}
