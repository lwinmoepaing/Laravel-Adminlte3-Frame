<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointmentables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('appointment_id')->constrained();
            $table->integer('appointmentable_id')->unsigned();
            $table->text('appointmentable_type');
            $table->tinyInteger('is_organizer');
            $table->foreignId('department_id')->nullable()->constrained();
            $table->integer('status')->default(1); // 1 => Pending, 2 => Going, 3 => Snooze
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
        Schema::dropIfExists('appointmentables');
    }
}
