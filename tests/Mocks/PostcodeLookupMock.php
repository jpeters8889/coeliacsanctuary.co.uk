<?php

declare(strict_types=1);

namespace Tests\Mocks;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Coeliac\Modules\Shop\PostcodeLookup\Parser;
use Coeliac\Modules\Shop\PostcodeLookup\Service;

class PostcodeLookupMock implements Service
{
    /**
     * @var Parser
     */
    private $parser;

    private Client $client;

    public function __construct(Client $client, Parser $parser)
    {
        $this->parser = $parser;
        $this->client = $client;
    }

    public function lookup($postcode): Collection
    {
        $response = json_encode([
            'addresses' => $this->getAddress(strtolower(trim($postcode))),
        ]);

        return $this->parser->parse(json_decode($response, false), $postcode);
    }

    /**
     * @param $postcode
     */
    private function getAddress($postcode): array
    {
        switch ($postcode) {
            case
            's653lh':
                return [
                    '2 Fretwell Road, East Herringthorpe, , , , Rotherham, South Yorkshire',
                    '20 Fretwell Road, East Herringthorpe, , , , Rotherham, South Yorkshire',
                    '4 Fretwell Road, East Herringthorpe, , , , Rotherham, South Yorkshire',
                ];
                break;
            case 'st42rw':
                return [
                    'Assist, Winton House, Stoke Road, , , Stoke-on-Trent, Staffordshire',
                    'Winton Property Ltd, Winton House, Stoke Road, , , Stoke-on-Trent, Staffordshire',
                ];
                break;
            case 'a1bcd':
                return [
                    '123 Fake Street, Nowhereville, Here, There, Everywhere, Cheshire',
                    '456 Fake Street, Nowhereville, Here, There, Everywhere, Cheshire',
                ];
                break;
            default:
                return [
                    '16 Gresty Terrace, , , , , Crewe, Cheshire',
                    '18 Gresty Terrace, , , , , Crewe, Cheshire',
                    '20 Gresty Terrace, , , , , Crewe, Cheshire',
                ];
        }
    }
}
