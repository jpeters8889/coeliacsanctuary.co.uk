<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class NewsletterSignupRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'url' => ['present'],
        ];
    }
}
