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
            $table->string('title')->index('appointment_title_index');
            $table->text('staff_name')->index('appointment_staff_name_index');
            $table->text('staff_email')->index('appointment_staff_email_index');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->timestamp('meeting_time')->index('appointment_meeting_time_index');
            $table->timestamp('meeting_leave_time')->nullable();
            $table->integer('status')->unsigned()->index('appointment_status_index');
            $table->text('reason')->nullable();
            $table->text('description')->nullable();
            $table->integer('create_type')->unsinged()->default(1); // From Client, From Recipient, From Admin
            $table->tinyInteger('is_approve_by_officer')->unsigned()->default(0);
            $table->tinyInteger('is_cancel_by_officer')->unsigned()->default(0);
            $table->foreignId('user_id')->nullable()->constraint();
            $table->foreignId('staff_id')->constraint();
            $table->foreignId('room_id')->nullable()->constrained();
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
