<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Coeliac\Common\Models\NotificationEmail;

class EmailRequest extends FormRequest
{
    protected ?NotificationEmail $email = null;

    public function rules()
    {
        return [];
    }

    public function email(): NotificationEmail
    {
        if ($this->email) {
            return $this->email;
        }

        /** @var ?NotificationEmail $email */
        $email = NotificationEmail::query()->where('key', $this->route('key'))->first();

        abort_if(!$email, 404);

        $this->email = $email;

        return $email;
    }
}
