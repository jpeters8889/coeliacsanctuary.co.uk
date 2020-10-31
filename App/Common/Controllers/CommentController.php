<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Requests\CommentRequest;
use Coeliac\Base\Controllers\BaseController;

class CommentController extends BaseController
{
    public function store(CommentRequest $request)
    {
        $request->model()->comments()->create($request->only(['name', 'email', 'comment']));

        return ['data' => 'Comment Created'];
    }
}
