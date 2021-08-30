<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class RecommendAPlaceRequest extends ApiFormRequest
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
            'email' => ['required', 'email'],
            'place_name' => 'required',
            'place_location' => 'required',
            'place_web_address' => 'nullable',
            'place_venue_type_id' => ['nullable', 'exists:wheretoeat_venue_types,id'],
            'place_details' => 'required',
        ];
    }
}
