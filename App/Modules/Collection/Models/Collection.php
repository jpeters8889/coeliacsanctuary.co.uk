<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\ClearsCache;
use Coeliac\Common\Traits\DisplaysImages;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\Linkable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @extends BaseModel<Collection>
 *
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

    protected function linkRoot(): string
    {
        return 'collection';
    }

    public function addItem(BaseModel $item, string $description, ?int $position = null): static
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
