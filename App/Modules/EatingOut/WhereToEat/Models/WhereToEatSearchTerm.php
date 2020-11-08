<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection<WhereToEatSearch> $searches
 * @property mixed                        $term
 */
class WhereToEatSearchTerm extends Model
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

    public function logSearch()
    {
        $this->searches()->create();
    }

    public function searches()
    {
        return $this->hasMany(WhereToEatSearch::class, 'search_term_id');
    }
}
