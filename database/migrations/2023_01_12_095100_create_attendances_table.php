<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('class_id', 128);
            $table->date('date');
            $table->string('shift', 10);
            $table->dateTime('cre_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('upd_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['class_id', 'date','shift']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
