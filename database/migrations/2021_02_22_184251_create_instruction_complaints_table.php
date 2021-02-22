<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('instruction_complaints')) {
            Schema::create('instruction_complaints', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned();
                $table->integer('instruction_id')->unsigned();
                $table->integer('instruction_сomplaint_status_id')->unsigned();
                $table->string('description');
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
        Schema::dropIfExists('instruction_complaints');
    }
}
