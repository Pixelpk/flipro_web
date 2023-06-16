<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_event_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('lead_id');
            $table->integer('email_campaign_id');
            $table->integer('email_campaign_event_id');
            $table->string('event_type');
            $table->longText('data');
            $table->integer('position');
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
        Schema::dropIfExists('campaign_event_logs');
    }
}
