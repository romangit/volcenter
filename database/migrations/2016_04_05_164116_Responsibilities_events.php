<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResponsibilitiesEvents extends Migration
{
    private $tableName = 'Responsibilities_events';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id'); // мероприятие
            $table->integer('responsibility_id'); // направление(-я) на мероприятие (аташе, team leader, логистика...)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
