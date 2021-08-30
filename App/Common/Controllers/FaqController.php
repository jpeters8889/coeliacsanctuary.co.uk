<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Common\Models\Accordion;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Http\Response;

class FaqController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'FAQ')
            ->setPageTitle('FAQ')
            ->setMetaDescription('Coeliac Sanctuary’s Frequently Asked Questions about Coeliac, gluten free and the website')
            ->setMetaKeywords(['faq', 'frequently asking questions', 'coeliac questions', 'coeliac diagnosis', 'gluten free diet', 'coeliac sanctuary questions'])
            ->setSocialImage(asset('assets/images/shares/faq.jpg'))
            ->render('pages.faq', [
                'accordions' => Accordion::query()->faq()->get()
            ]);
    }
}
