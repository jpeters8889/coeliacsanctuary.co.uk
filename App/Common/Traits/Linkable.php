<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Support\Str;

/**
 * @property mixed $link
 * @property mixed $absolute_link
 */
trait Linkable
{
    public function initializeLinkable(): void
    {
        $this->append('link');
    }

    public function getLinkAttribute(): string
    {
        return '/' . $this->linkRoot() . '/' . $this->linkColumn();
    }

    public function getAbsoluteLinkAttribute(): string
    {
        return config('app.url') . $this->link;
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
