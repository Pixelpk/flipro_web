<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailCampaignEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_campaign_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->longText('data');
            $table->integer('position')->default(0)->nullable();
            $table->integer('email_campaign_id')->unsigned()->index();
            $table->softDeletes();
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
        Schema::dropIfExists('email_campaign_events');
    }
}
