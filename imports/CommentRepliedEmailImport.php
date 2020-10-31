<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Comments\Commentable;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Common\Models\NotificationEmail;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Common\Comments\Notifications\CommentRepliedNotification;

class CommentRepliedEmailImport extends Import
{
    public function handle()
    {
        $seeds = $this->campaignDatabase
            ->table('sent_transactional')
            ->where('template', 'commentReply')
            ->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        $bar->start();

        foreach ($seeds as $seed) {
            if (!$comment = $this->resolveComment($seed)) {
                $bar->advance();
                continue;
            }

            if (!$comment->reply) {
                $bar->advance();
                continue;
            }

            $notification = new CommentRepliedNotification($comment, $comment->reply);
            $notification->forceDate(Carbon::createFromFormat('d/m/Y', json_decode($seed->mergeTags, true)['header']['date']));

            NotificationEmail::query()->create([
                'key' => $seed->token,
                'email_address' => $seed->toEmail,
                'template' => $notification->toMail()->mjml,
                'data' => $notification->toMail()->viewData,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }

    private function resolveComment($seed): ?Comment
    {
        $data = json_decode($seed->mergeTags, true);

        switch ($data['what']) {
            case 'blog':
                $model = Blog::class;
                break;
            case 'recipe':
                $model = Recipe::class;
                break;
            case 'review':
                $model = Review::class;
                break;
            default:
                return null;
        }

        /** @var Commentable $commentable */
        $commentable = $model::query()->where('title', $data['title'])->first();

        if (!$commentable) {
            return null;
        }

        return $commentable->comments()->where('email', $seed->toEmail)->first();
    }
}
