<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Comments\Commentable;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class CommentImport extends Import
{
    public function handle()
    {
        $seeds = $this->seedDatabase->table('comments')->whereNull('adminReply')->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        $bar->start();

        foreach ($seeds as $comment) {
            switch ($comment->area) {
                case 'blog':
                    $class = Blog::class;
                    $table = 'blogs';
                    $column = 'slug';
                    break;
                case 'recipe':
                    $class = Recipe::class;
                    $table = 'recipes';
                    $column = 'slug';
                    break;
                case 'review':
                    $class = Review::class;
                    $table = 'reviews';
                    $column = 'legacy_slug';
                    break;
                default:
                    continue 2;
            }

            $oldItem = $this->seedDatabase->table($table)->find($comment->itemID, ['alias']);

            if (!$oldItem) {
                continue;
            }

            /** @var Commentable $item */
            $item = $class::query()->where($column, $oldItem->alias)->first();

            if (!$item) {
                continue;
            }

            $item->comments()->create([
                'name' => stripslashes($comment->name),
                'email' => $comment->email,
                'comment' => stripslashes($this->replace($comment->comment)),
                'approved' => $comment->approved,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('Importing Replies');

        $adminReplies = $this->seedDatabase->table('comments')->whereNotNull('adminReply')->get();

        $bar = $this->command->makeProgressBar(count($adminReplies));
        $bar->start();

        foreach ($adminReplies as $adminReply) {
            $oldComment = $this->seedDatabase->table('comments')->find($adminReply->adminReply);

            /** @var Comment $parent */
            $parent = Comment::query()
                ->where('name', $oldComment->name)
                ->where('email', $oldComment->email)
                ->where('comment', $this->replace($oldComment->comment))
                ->first(['id']);

            if (!$parent) {
                continue;
            }

            $parent->reply()->create([
                'comment_id' => $parent->id,
                'comment_reply' => stripslashes($adminReply->comment),
                'created_at' => $adminReply->created_at,
                'updated_at' => $adminReply->updated_at,
            ]);

            $bar->advance();
        }
        $bar->finish();
    }

    private function replace($string)
    {
        return str_replace(["\n", 'â€™'], ['<br/>', "'"], $string);
    }
}
