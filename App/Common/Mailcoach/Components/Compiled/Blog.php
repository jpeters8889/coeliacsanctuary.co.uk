<?php

namespace Coeliac\Common\Mailcoach\Components\Compiled;

use Coeliac\Modules\Blog\Models\Blog as BlogModel;
use Livewire\Component;

class Blog extends Component
{
    public array $properties;

    public ?int $blogId = null;

    public BlogModel $blog;

    public string $block;

    public function mount()
    {
        $this->blogId = $this->properties['content'] ?? null;

        if ($this->blogId) {
            $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
        }
    }

    public function hydrate()
    {
        $this->blogId = $this->properties['content'] ?? null;

        if ($this->blogId) {
            $this->blog = BlogModel::query()->where('live', true)->find($this->blogId);
        }
    }

    public function render()
    {
        return view('mailables.mjml.newsletter.components.compiled.components.blog');
    }
}
