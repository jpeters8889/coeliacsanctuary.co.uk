<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\PostcodeLookup\GetAddress;

use Exception;
use Illuminate\Support\Collection;
use Coeliac\Modules\Shop\PostcodeLookup\Parser as ParserContract;

class Parser implements ParserContract
{
    public function parse(object $response, string $postcode): Collection
    {
        if (!$response->addresses) {
            throw new Exception('No results');
        }

        return (new Collection($response->addresses))->transform(function ($address) use ($postcode) {
            return $this->processAddress($address, $postcode);
        })->sortBy('house_number')->values();
    }

    private function processAddress(string $address, string $postcode): array
    {
        $parts = (new Collection(explode(',', $address)))
            ->reject(static function ($part) {
                return trim($part) === '';
            })
            ->transform(static function ($part) {
                return trim($part);
            })
            ->values();

        $result = $this->addressArray($postcode, $parts);

        $result['friendly'] = implode(', ', array_filter($result));
        $result['house_number'] = (int) explode(' ', $result['address_1'])[0];

        return $result;
    }

    private function addressArray(string $postcode, Collection $parts): array
    {
        if ($parts->count() > 2) {
            $county = $parts->pop();
        }

        $town = $parts->pop();

        return [
            'address_1' => $parts->shift(),
            'address_2' => $parts->shift() ?: null,
            'address_3' => $parts->implode(', ') ?: null,
            'town' => $town,
            'county' => $county ?? '',
            'postcode' => strtoupper($postcode),
        ];
    }
}
