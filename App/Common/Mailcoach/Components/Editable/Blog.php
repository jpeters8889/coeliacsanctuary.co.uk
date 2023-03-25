<?php

namespace Coeliac\Common\Mailcoach\Components\Editable;

use Coeliac\Modules\Blog\Models\Blog as BlogModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Blog extends Component
{
    public string $blockId;

    public string $block;

    public int $index;

    public array $properties;

    public string $description = '';

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
            $this->description = $this->block === 'single' ? $this->blog->description : $this->blog->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
        }
    }

    public function hydrate()
    {
        $this->blogId = $this->properties['content'] ?? null;
        $this->results = new Collection();

        if ($this->blogId) {
            $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
            $this->description = $this->block === 'single' ? $this->blog->description : $this->blog->meta_description;
        }

        if (isset($this->properties['description'])) {
            $this->description = $this->properties['description'];
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

    public function updatedDescription()
    {
        $this->properties['description'] = $this->description;

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
        $this->description = $this->block === 'single' ? $this->blog->description : $this->blog->meta_description;
        $this->results = new Collection();
        $this->search = '';
        $this->updatedBlog();
    }
}
