<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('competition_id');
            $table->string('name');
            $table->string('email');
            $table->string('entry_type', 16);
            $table->timestamps();

            $table->unique(['competition_id', 'name', 'email', 'entry_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_entries');
    }
}
