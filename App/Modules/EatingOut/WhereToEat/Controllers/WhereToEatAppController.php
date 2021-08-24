<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;

class WhereToEatAppController extends BaseController
{
    public function get(Page $page)
    {
        return $page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
                [
                    'link' => '/wheretoeat',
                    'title' => 'Places to Eat',
                ],
            ], 'Coeliac Sanctuary - On the Go')
            ->setPageTitle('Coeliac Sanctuary - On the Go')
            ->setMetaDescription('Coeliac Sanctuary on the go | Find Gluten Free places to eat out across the UK with our Coeliac Sanctuary - On the Go app')
            ->setMetaKeywords([
                'Coeliac sanctuary app', 'gluten free places to eat', 'coeliac sanctuary on the go', 'coeliac places to eat', 'android app',
            ])
            ->setSocialImage(asset('assets/images/shares/wheretoeat-app.jpg'))
            ->render('modules.eating-out.wheretoeat.app');
    }
}
