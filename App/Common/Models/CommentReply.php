<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<CommentReply> */
class CommentReply extends BaseModel
{
    protected $visible = [
        'comment_reply',
        'created_at',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
