<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->longText('subject');
            $table->longText('message');
            $table->string('from');
            $table->string('to');
            $table->string('spf')->nullable();
            $table->string('dkim')->nullable();
            $table->string('message_id')->nullable();
            $table->integer('user_id');
            $table->integer('lead_id')->nullable();
            $table->dateTime('email_date');
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
        Schema::dropIfExists('emails');
    }
}
