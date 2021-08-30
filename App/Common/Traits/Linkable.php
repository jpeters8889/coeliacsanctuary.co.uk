<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Support\Str;

trait Linkable
{
    public function initializeLinkable(): void
    {
        $this->append('link');
    }

    public function getLinkAttribute(): string
    {
        return '/'.$this->linkRoot().'/'.$this->linkColumn();
    }

    protected function linkRoot(): string
    {
        return Str::plural(Str::lower(class_basename($this)));
    }

    protected function linkColumn(): string
    {
        return $this->slug;
    }
}
