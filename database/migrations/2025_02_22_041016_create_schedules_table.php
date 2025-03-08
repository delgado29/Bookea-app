<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * This table stores when an employee is available for appointments.
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // The employee
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('business_id')
                  ->constrained('businesses')
                  ->onDelete('cascade');
            $table->string('day_of_week'); // e.g. 'Monday', 'Tuesday', or numeric 1..7
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}