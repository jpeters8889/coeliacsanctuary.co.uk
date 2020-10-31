<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatAssignedFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_assigned_features', function (Blueprint $table) {
            $table->primary(['wheretoeat_id', 'feature_id']);
            $table->unsignedInteger('wheretoeat_id');
            $table->unsignedInteger('feature_id');
            $table->timestamps();

            $table->foreign('wheretoeat_id')->references('id')->on('wheretoeat')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('wheretoeat_features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat_assigned_features');
    }
}
