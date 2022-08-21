<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @extends BaseModel<Comment>
 *
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property string $commentable_type
 */
class Comment extends BaseModel
{
    protected $visible = [
        'name',
        'comment',
        'created_at',
        'reply',
    ];

    protected $appends = ['what'];

    protected $attributes = [
        'approved' => false,
    ];

    public function reply(): HasOne
    {
        return $this->hasOne(CommentReply::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getWhatAttribute(): string
    {
        return class_basename($this->commentable_type);
    }
}
