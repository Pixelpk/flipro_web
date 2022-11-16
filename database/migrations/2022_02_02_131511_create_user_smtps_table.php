<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSmtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_smtps', function (Blueprint $table) {
            $table->id();
            $table->string('incomming_server');
            $table->string('outgoing_server');
            $table->string('incomming_port')->default('995');
            $table->string('outgoing_port')->default('456');
            $table->string('username');
            $table->string('password');
            $table->string('auth')->default('none');
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
        Schema::dropIfExists('user_smtps');
    }
}
