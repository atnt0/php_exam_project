<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionComplaintStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('instruction_complaint_statuses')) {
            Schema::create('instruction_complaint_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title');
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
        Schema::dropIfExists('instruction_complaint_statuses');
    }
}
