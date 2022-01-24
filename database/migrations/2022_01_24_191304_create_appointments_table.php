<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('staff_name');
            $table->text('staff_email');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->timestamp('meeting_time');
            $table->integer('status')->unsigned()->index('appointment_status_index');
            $table->text('reason')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constraint();
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
        Schema::dropIfExists('appointments');
    }
}
