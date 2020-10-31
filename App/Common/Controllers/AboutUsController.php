<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Base\Controllers\BaseController;

class AboutUsController extends BaseController
{
    public function get(Page $page, Repository $repository)
    {
        return $page
            ->breadcrumbs([], 'About Us')
            ->setPageTitle('About Us')
            ->setMetaDescription('Find out more about Coeliac Sanctuary, our history, and the people who run it!')
            ->setMetaKeywords(['Places to eat', 'gluten free recipes', 'coeliac sanctuary about', 'coeliac sanctuary history'])
            ->setSocialImage(asset('assets/images/shares/about.jpg'))
            ->render('pages.about', [
                'related' => $repository->take(7),
            ]);
    }
}
