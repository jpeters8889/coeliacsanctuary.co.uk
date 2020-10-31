<?php

declare(strict_types=1);

namespace Coeliac\Common\Casts;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\CommentReply;
use Coeliac\Common\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;
use function Symfony\Component\String\s;

class EmailData implements CastsAttributes
{
    /**
     * {@inheritdoc}
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $data = json_decode($value, true);

        if (isset($data['date'])) {
            $data['date'] = Carbon::make($data['date']);
        }

        if (isset($data['comment'])) {
            $data['comment'] = Comment::query()->find($data['comment']['id']);
        }

        if (isset($data['reply'])) {
            $data['reply'] = CommentReply::query()->find($data['reply']['id']);
        }

        if (isset($data['rating'])) {
            $data['rating'] = WhereToEatRating::query()->find($data['rating']['id']);
        }

        if(isset($data['order'])) {
            $data['order'] = ShopOrder::query()->find($data['order']['id']);
        }

        if(isset($data['notifiable'])) {
            $data['notifiable'] = User::query()->find($data['notifiable']['id']);
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
