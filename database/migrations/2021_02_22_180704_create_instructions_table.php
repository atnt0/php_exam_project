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
                $table->string('description', 255);
                $table->string('file_name', 255);
                $table->integer('status')->default(1);
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
