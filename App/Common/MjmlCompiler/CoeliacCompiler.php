<?php

declare(strict_types=1);

namespace Coeliac\Common\MjmlCompiler;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\HtmlString;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class CoeliacCompiler implements CompilerContract
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Container::getInstance()->make(ConfigRepository::class)->get('services.mjml.compiler'),
            'headers' => [
                'Content-Type' => 'text/plain',
            ],
        ]);
    }

    public function compile($mjml)
    {
        try {
            $request = $this->client->post('', [
                'json' => ['mjml' => $mjml],
            ]);

            $content = json_decode($request->getBody()->getContents(), true)['html'];
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            $content = $mjml;
        }

        return ['html' => new HtmlString($content)];
    }
}
