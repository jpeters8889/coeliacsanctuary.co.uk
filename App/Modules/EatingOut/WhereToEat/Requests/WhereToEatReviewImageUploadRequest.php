<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class WhereToEatReviewImageUploadRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'images' => ['required', 'array', 'max:6'],
            'images.*' => ['file', 'image', 'mimetypes:image/jpg,image/jpeg,image/png,image/gif', 'max:5120'],
        ];
    }
}
