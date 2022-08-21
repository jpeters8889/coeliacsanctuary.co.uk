<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Events\ContactFormSubmitted;
use Coeliac\Common\Requests\ContactRequest;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Response;

class ContactController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'Contact Us')
            ->setPageTitle('Contact Us')
            ->setMetaDescription('Contact the team at Coeliac Sanctuary via our contact form')
            ->setSocialImage(asset('assets/images/shares/contact.jpg'))
            ->render('pages.contact');
    }

    public function store(ContactRequest $request, Dispatcher $events): Response
    {
        $events->dispatch(new ContactFormSubmitted($request->validated()));

        return new Response(['data' => 'ok']);
    }
}
