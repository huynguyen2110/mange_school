<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->string('class_id', 128);
            $table->string('student_id', 128);
            $table->string('midterm_score', 10)->nullable();
            $table->string('final_score', 10)->nullable();
            $table->string('total', 10)->nullable();
            $table->dateTime('cre_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('upd_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->primary(['student_id', 'class_id', 'midterm_score', 'final_score']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
