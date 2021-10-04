<?php

namespace Database\Factories;

use Coeliac\Common\Comments\Commentable;
use Coeliac\Common\Contracts\HasComments;
use Coeliac\Common\Models\Comment;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->paragraph,
        ];
    }

    public function on(HasComments $commentable)
    {
        return $this->state(fn (array $attributes) => [
           'commentable_type' => $commentable::class,
           'commentable_id' => $commentable->id,
        ]);
    }
}
