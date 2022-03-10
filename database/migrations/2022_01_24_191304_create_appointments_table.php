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
            $table->string('organizer_name')->index('appointment_organizer_name');
            $table->string('readable_id')->nullable()->unique()->index('appointment_readable_id');

            $table->timestamp('meeting_request_time');
            $table->timestamp('meeting_start_time')->nullable()->index('appointment_meeting_time_index');
            $table->timestamp('meeting_leave_time')->nullable();

            $table->integer('status')->unsigned()->index('appointment_status_index');
            $table->text('reason')->nullable();
            $table->text('description')->nullable();

            $table->integer('create_type')->unsinged()->default(1); // From Client => 1, From Recipient => 2 , From Officer => 3, From Admin
            $table->foreignId('branch_id')->constrained();
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
