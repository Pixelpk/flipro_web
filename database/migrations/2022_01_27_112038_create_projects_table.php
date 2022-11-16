<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('anticipated_budget');
            $table->integer('project_address');
            $table->integer('project_state');
            $table->integer('contractor_supplier_details');
            $table->string('applicant_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('applicant_address')->nullable();
            $table->string('registered_owners')->nullable();
            $table->integer('current_property_value')->nullable();
            $table->integer('property_debt')->nullable();
            $table->boolean('cross_collaterized')->nullable();
            $table->string('status')->default('new');
            $table->json('photos');
            $table->json('videos');
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
        Schema::dropIfExists('projects');
    }
}
