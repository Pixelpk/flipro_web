<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletedAtInEmailCampaignEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_campaign_events', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('email_campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_campaign_events', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
}
