<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments;

use Coeliac\Common\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->where('approved', true)->orderByDesc('created_at');
    }

    public function allComments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
