<?php

declare(strict_types=1);

namespace Coeliac\Common\Events;

class ContactFormSubmitted
{
    protected array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function request()
    {
        return $this->request;
    }
}
