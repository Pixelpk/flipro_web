<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientValuesToPropertyValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_values', function (Blueprint $table) {
            $table->boolean('client_satisfied')->nullable();
            $table->longText('client_reviews')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_values', function (Blueprint $table) {
            $table->dropColumn('client_satisfied');
            $table->dropColumn('client_reviews');
        });
    }
}
