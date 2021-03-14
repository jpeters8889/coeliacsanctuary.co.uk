<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('meta_keywords');
            $table->text('meta_description');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('promote_on_banner')->default(false);
            $table->boolean('enable_facebook_like')->default(false);
            $table->boolean('enable_facebook_share')->default(false);
            $table->boolean('enable_twitter_follow')->default(false);
            $table->boolean('enable_twitter_tweet')->default(false);
            $table->boolean('enable_shop_purchase')->default(false);
            $table->text('terms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
