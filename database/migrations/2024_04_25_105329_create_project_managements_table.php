<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_managements', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('assign')->nullable();
            $table->string('total_hours')->nullable();
            $table->string('payment')->nullable();
            $table->string('deadline')->nullable();
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
        Schema::dropIfExists('project_managements');
    }
};
