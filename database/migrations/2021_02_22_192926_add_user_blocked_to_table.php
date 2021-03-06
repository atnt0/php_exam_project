<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserBlockedToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // IF EXISTS !!!
        if ( Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('blocked_at')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //Schema::dropIfExists('blocked_at_to_users');
        });
    }
}
