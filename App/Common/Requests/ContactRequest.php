<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class ContactRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ];
    }
}
