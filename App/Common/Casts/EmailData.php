<?php

declare(strict_types=1);

namespace Coeliac\Common\Casts;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\CommentReply;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;
use Illuminate\Support\Collection;

class EmailData implements CastsAttributes
{
    /**
     * {@inheritdoc}
     * @return array
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $data = json_decode($value, true);

        if (isset($data['date'])) {
            $data['date'] = Carbon::make($data['date']);
        }

        if (isset($data['comment'])) {
            if (!isset($data['comment']['id'])) {
                $data['comment'] = Comment::query()
                    ->where('created_at', $data['comment']['created_at'])
                    ->where('name', $data['comment']['name'])
                    ->first();
            } else {
                $data['comment'] = Comment::query()->find($data['comment']['id']);
            }
        }

        if (isset($data['reply'])) {
            $data['reply'] = CommentReply::query()->find($data['reply']['id']);
        }

        if (isset($data['rating'])) {
            $data['rating'] = WhereToEatRating::query()->find($data['rating']['id']);
        }

        if (isset($data['order'])) {
            $data['order'] = ShopOrder::query()->find($data['order']['id']);
        }

        if (isset($data['notifiable'])) {
            $data['notifiable'] = User::query()->find($data['notifiable']['id']);
        }

        if (isset($data['updates'])) {
            if (isset($data['updates']['blogs'])) {
                if (isset($data['updates']['blogs']['subscriptions'])) {
                    $data['updates']['blogs']['subscriptions'] = new Collection($data['updates']['blogs']['subscriptions']);
                }

                $data['updates']['blogs'] = new Collection($data['updates']['blogs']);
            }

            if (isset($data['updates']['eateries'])) {
                if (isset($data['updates']['eateries']['subscriptions'])) {
                    $data['updates']['eateries']['subscriptions'] = new Collection($data['updates']['eateries']['subscriptions']);
                }
                $data['updates']['eateries'] = new Collection($data['updates']['eateries']);
            }

            $data['updates'] = new Collection($data['updates']);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}
