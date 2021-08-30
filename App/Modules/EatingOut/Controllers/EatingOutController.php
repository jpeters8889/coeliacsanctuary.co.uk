<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Http\Response;

class EatingOutController extends BaseController
{
    public function index(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'Eating Out')
            ->setPageTitle('Gluten Free Eating Out')
            ->setMetaDescription('Coeliac Sanctuary places to eat overview |Find gluten free places to eat in the UK, attractions and hotels catering to Coeliac and reviews of places')
            ->setMetaKeywords(['Gluten free eating out', 'coeliac eating out', 'reviews', 'places to eat', 'uk places to eat', 'gluten free places to eat uk', 'attractions uk gluten free', 'gluten free reviews', 'coeliac reviews', 'gluten free hotels', 'gluten free restaurants uk', 'gluten free cafes uk'])
            ->setSocialImage(asset('assets/images/shares/eating-index.jpg'))
            ->render('modules.eating-out.index');
    }
}
