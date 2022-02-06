<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class NewsletterRenderRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'introText' => 'required',
            'recipes' => ['required', 'array', 'size:3'],
            'blogs' => ['required', 'array', 'size:2'],
//            'reviews' => ['required', 'array', 'size:2'],
        ];
    }
}
