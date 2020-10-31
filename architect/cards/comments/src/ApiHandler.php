<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\CommentReply;
use Illuminate\Notifications\AnonymousNotifiable;
use Coeliac\Common\Comments\Notifications\CommentRepliedNotification;
use Coeliac\Common\Comments\Notifications\CommentApprovedNotification;

class ApiHandler
{
    public function delete($id)
    {
        Comment::query()->findOrFail($id)->delete();

        return new Response();
    }

    public function approve($id)
    {
        /** @var Comment $comment */
        $comment = Comment::query()->findOrFail($id);
        $comment->update(['approved' => 1]);

        (new AnonymousNotifiable())
            ->route('mail', $comment->email)
            ->notify(new CommentApprovedNotification($comment));

        return new Response();
    }

    public function reply(Request $request, $id)
    {
        /** @var Comment $comment */
        $comment = Comment::query()->findOrFail($id);

        /** @var CommentReply $reply */
        $reply = $comment->reply()->create([
            'comment_reply' => $request->input('reply'),
        ]);

        $comment->update(['approved' => 1]);

        (new AnonymousNotifiable())
            ->route('mail', $comment->email)
            ->notify(new CommentRepliedNotification($comment, $reply));

        return new Response();
    }
}
