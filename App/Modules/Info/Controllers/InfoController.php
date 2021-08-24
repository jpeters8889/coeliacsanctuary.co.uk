<?php

declare(strict_types=1);

namespace Coeliac\Modules\Info\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Common\Models\Accordion;
use Coeliac\Base\Controllers\BaseController;

class InfoController extends BaseController
{
    private Page $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index()
    {
        return $this->page
            ->breadcrumbs([], 'Info')
            ->setPageTitle('Coeliac Information')
            ->setMetaDescription('Find out about Coeliac, beginners shopping list, gluten challenge information and cupboard guide right here')
            ->setMetaKeywords(['Coeliac information', 'coeliac diagnosis', 'coeliacs shopping lists', 'beginners gluten free shopping list', 'beginners gluten free guide', 'gluten free storecupboard staples'])
            ->setSocialImage(asset('assets/images/shares/info-index.jpg'))
            ->render('modules.info.index');
    }

    public function coeliacInfo()
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/info',
                    'title' => 'Info',
                ],
            ], 'Coeliac Information')
            ->setPageTitle('About Coeliac Disease and Gluten Free Living')
            ->setMetaDescription('Do you need some information about Coeliac Disease? Take a look here')
            ->setMetaKeywords(['Coeliac information', 'coeliac diagnosis', 'coeliac symptoms', 'coeliac info', 'what is coeliac'])
            ->setSocialImage(asset('assets/images/shares/info-coeliac.jpg'))
            ->render('modules.info.coeliac', [
                'accordions' => Accordion::query()->coeliacInfo()->get(),
            ]);
    }

    public function shoppingList()
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/info',
                    'title' => 'Info',
                ],
            ], 'Shopping List')
            ->setPageTitle('Gluten Free Shopping List')
            ->setMetaDescription('If you are new to a gluten free diet it’s hard to figure out what you can eat, here’s our beginners gluten free shopping list to help you along')
            ->setMetaKeywords(['Gluten free shopping list', 'coeliac beginners shopping list', 'gluten free shopping list', 'gluten free quick guide', 'shopping list', 'gluten free diet'])
            ->setSocialImage(asset('assets/images/shares/info-shopping-list.jpg'))
            ->render('modules.info.shopping');
    }

    public function storecupboard()
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/info',
                    'title' => 'Info',
                ],
            ], 'Storecupboard Checklist')
            ->setPageTitle('Gluten Free Storecupboard Checklist')
            ->setMetaDescription('List of the basic storecupboard staples you should check to see are gluten free and suitable for Coeliacs')
            ->setMetaKeywords(['Gluten free food', 'gluten free staples', 'gluten free staple foods', 'food checker', 'gluten free list', 'gluten free basics list'])
            ->setSocialImage(asset('assets/images/shares/info-storecupboard.jpg'))
            ->render('modules.info.storecupboard');
    }

    public function glutenChallenge()
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/info',
                    'title' => 'Info',
                ],
            ], 'Gluten Challenge')
            ->setPageTitle('Gluten Challenge Information')
            ->setMetaDescription('Coeliac Sanctuary gluten challenge guide for if you are being testing for Coeliac')
            ->setMetaKeywords(['Gluten challenge', 'coeliac diagnosis', 'gluten testing', 'coeliac testing', 'six week gluten challenge', 'testing for coeliac', 'gluten free diet'])
            ->setSocialImage(asset('assets/images/shares/info-gluten.jpg'))
            ->render('modules.info.gluten');
    }
}
