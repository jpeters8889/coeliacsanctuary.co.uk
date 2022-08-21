<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Updatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<BlogTag>
 *
 * @property string $slug
 * @property string $tag
 * @property string $link
 */
class BlogTag extends BaseModel implements Updatable
{
    protected $appends = ['link'];

    protected $visible = [
        'id',
        'tag',
        'slug',
        'link',
    ];

    public function getLinkAttribute(): string
    {
        return '/blog?o='.base64_encode('filter[tags]='.$this->slug);
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_assigned_tags', 'tag_id', 'blog_id');
    }

    public function updatableName(): string
    {
        return $this->tag;
    }

    public function updatableLink(): string
    {
        return $this->link;
    }
}
