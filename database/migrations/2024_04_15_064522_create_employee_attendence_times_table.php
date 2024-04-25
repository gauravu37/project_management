<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendence_times', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id')->default('0');
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();
            $table->string('total_hours')->nullable();
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
        Schema::dropIfExists('employee_attendence_times');
    }
};
