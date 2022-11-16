<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableInUserSmtps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_smtps', function (Blueprint $table) {
            $table->string('incomming_server')->nullable()->change();
            $table->string('outgoing_server')->nullable()->change();
            $table->string('incomming_port')->nullable()->change();
            $table->string('outgoing_port')->nullable()->change();
            $table->string('username')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('auth')->nullable()->change();
            $table->string('sender_name')->nullable()->change();
            $table->string('authentication_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_smtps', function (Blueprint $table) {
            //
        });
    }
}
