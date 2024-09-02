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
        Schema::create('finance_managements', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('tds_deduct')->nullable();
            $table->string('actual_amount')->nullable();
            $table->string('date')->nullable();
            $table->string('gst_recieved')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_amount')->nullable();
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
        Schema::dropIfExists('finance_managements');
    }
};
