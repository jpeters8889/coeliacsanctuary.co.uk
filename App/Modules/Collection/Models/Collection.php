<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\Linkable;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\ClearsCache;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\DisplaysImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @property EloquentCollection<CollectionItem> $items
 * @property string                             $title
 * @property string                             $body
 * @property string                             $long_description
 * @property string                             $meta_description
 * @property string                             $meta_keywords
 * @property mixed                              $slug
 */
class Collection extends BaseModel
{
    use ArchitectModel;
    use DisplaysImages;
    use Imageable;
    use Linkable;
    use ClearsCache;

    protected $appends = ['main_image'];

    protected $hidden = ['images'];

    public function items(): HasMany
    {
        return $this->hasMany(CollectionItem::class)->orderBy('position');
    }

    protected function linkRoot()
    {
        return 'collection';
    }

    public function addItem(BaseModel $item, string $description, $position = null): self
    {
        $this->items()->create([
            'item_id' => $item->getKey(),
            'item_type' => get_class($item),
            'description' => $description,
            'position' => $position ?? $this->items()->max('position') + 1,
        ]);

        return $this;
    }

    protected function cacheKey(): string
    {
        return 'collections';
    }
}
