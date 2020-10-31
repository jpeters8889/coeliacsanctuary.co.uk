<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentReply extends BaseModel
{
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
