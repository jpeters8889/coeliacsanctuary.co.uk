<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Support\Str;

trait Linkable
{
    public function initializeLinkable()
    {
        $this->append('link');
    }

    public function getLinkAttribute()
    {
        return '/'.$this->linkRoot().'/'.$this->linkColumn();
    }

    protected function linkRoot()
    {
        return Str::plural(Str::lower(class_basename($this)));
    }

    protected function linkColumn()
    {
        return $this->slug;
    }
}
