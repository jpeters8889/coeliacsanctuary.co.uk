<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Architect;

use Carbon\Carbon;
use JPeters\Architect\Plans\Body;
use JPeters\Architect\Plans\Group;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Architect\Plans\ImageManager\Plan;
use Coeliac\Modules\Competition\Models\Competition;
use JPeters\Architect\Blueprints\Blueprint as Architect;
use Coeliac\Architect\Plans\CompetitionEntries\Plan as CompetitionEntries;

class Blueprint extends Architect
{
    public function model(): string
    {
        return Competition::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->withCount('entries');
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Textfield::generate('meta_keywords')->hideOnIndex(),

            Textarea::generate('meta_description'),

            Plan::generate('images')
                ->disableSocialImageOption()
                ->disableSquareImageOption()
                ->setImageDirectory('competitions')
                ->setUploadDirectoryColumn('uuid')
                ->hideOnIndex(),

            Body::generate('architect_body', 'Page Body')->hideOnIndex(),

            CompetitionEntries::generate('entries_count')->hideOnForms(),

            DateTime::generate('start_at', 'Entries Open At')
                ->setDefault(Carbon::tomorrow()->startOfDay()->toIso8601String()),

            DateTime::generate('end_at', 'Entries Close At')
                ->setDefault(Carbon::tomorrow()->addWeek()->endOfDay()->toIso8601String()),

            Boolean::generate('promote_on_banner', 'Promote the competition at the top of the website')
                ->hideOnIndex(),

            Group::generate('options', 'Entry Options')
                ->hideOnIndex()
                ->plans([
                    Boolean::generate('enable_facebook_like', 'Facebook Like')
                        ->setDefault('1'),

                    Boolean::generate('enable_facebook_share', 'Facebook Share')
                        ->setDefault('1'),

                    Boolean::generate('enable_twitter_follow', 'Twitter Follow')
                        ->setDefault('1'),

                    Boolean::generate('enable_twitter_tweet', 'Twitter Tweet')
                        ->setDefault('1'),

                    Boolean::generate('enable_shop_purchase', 'Shop Purchase')
                        ->setDefault('0'),
                ]),

            Body::generate('terms', 'Competition Terms')->hideOnIndex(),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }
}
