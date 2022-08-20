<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property Collection<WhereToEatSearch> $searches
 * @property mixed                        $term
 * @property string $key
 */
class WhereToEatSearchTerm extends BaseModel
{
    protected $guarded = [];

    protected $table = 'wheretoeat_search_terms';

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (WhereToEatSearchTerm $searchTerm) {
            $pass = false;

            while ($pass === false) {
                $key = Str::random(16);

                if (static::query()->where('key', $key)->count() === 0) {
                    $pass = true;
                }
            }

            $searchTerm->key = $key;

            return $searchTerm;
        });
    }

    public function logSearch(): void
    {
        $this->searches()->create();
    }

    public function searches(): HasMany
    {
        return $this->hasMany(WhereToEatSearch::class, 'search_term_id');
    }
}
