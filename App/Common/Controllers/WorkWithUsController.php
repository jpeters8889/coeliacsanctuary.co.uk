<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Base\Controllers\BaseController;

class WorkWithUsController extends BaseController
{
    public function get(Page $page, Repository $repository)
    {
        return $page
            ->breadcrumbs([], 'Work With Us')
            ->setPageTitle('Work With Coeliac Sanctuary')
            ->setMetaDescription('Want Coeliac Sanctuary to help promote your brand? Find out how we can help here!')
            ->render('pages.work-with-us', [
                'related' => $repository->take(3),
            ]);
    }
}
