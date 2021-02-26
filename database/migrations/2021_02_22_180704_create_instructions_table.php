<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('instructions')) {
            Schema::create('instructions', function (Blueprint $table) {
                $table->id();
                $table->string('title', 100);
                $table->string('description', 511);
                $table->string('file_name', 255);
                $table->integer('status_approved')->default(0);
                $table->integer('author_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructions');
    }
}
