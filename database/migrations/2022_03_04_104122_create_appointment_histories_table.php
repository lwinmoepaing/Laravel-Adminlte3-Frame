<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentHistoriesTable extends Migration
{

    public $HistoryTypes = [
        'CREATE_APPOINTMENT',
        'UPDATE_APPOINTMENT',
        'UPDATE_APPOINTMENT_ATTENDANCE',
        'CHANGE_APPOINTMENT_STATUS',
        'CANCEL_APPOINTMENT'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained();
            $table->text('message');
            $table->text('appoint_history_type')->default($this->HistoryTypes[0]);
            $table->longText('history_data');
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
        Schema::dropIfExists('appointment_histories');
    }
}
