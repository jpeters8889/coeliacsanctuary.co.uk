<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $name
 * @property string $email
 * @property string $comment
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

    public function getWhatAttribute()
    {
        return class_basename($this->commentable_type);
    }
}
