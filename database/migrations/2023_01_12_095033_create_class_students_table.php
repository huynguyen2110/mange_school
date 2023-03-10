<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 128);
            $table->string('class_id', 128);
            $table->dateTime('cre_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('upd_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['student_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_students');
    }
}
