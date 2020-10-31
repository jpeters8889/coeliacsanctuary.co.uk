<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\PostcodeLookup\GetAddress;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Coeliac\Modules\Shop\PostcodeLookup\Parser;
use Coeliac\Modules\Shop\PostcodeLookup\Service;

class Lookup implements Service
{
    private Client $client;
    private Parser $parser;

    public function __construct(Client $client, Parser $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    public function lookup($postcode): Collection
    {
        $request = $this->client->get(
            implode('/', [
                'find',
                $postcode,
            ])
        );

        return $this->parser->parse(json_decode($request->getBody()->getContents(), false), $postcode);
    }
}
