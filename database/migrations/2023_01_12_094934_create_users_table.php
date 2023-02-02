<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->comment('Random 20-digit alphanumerical');
            $table->string('name', 128);
            $table->string('course_id', 128)->nullable();
            $table->string('major_id', 128)->nullable();
            $table->string('email', 255)->unique();
            $table->string('password', 1024);
            $table->string('role', 10)->default(1);
            $table->date('birthday')->nullable();
            $table->string('year_of_admission', 10)->nullable();
            $table->string('gender', 128)->nullable();
            $table->string('phone', 24)->nullable()->unique();
            $table->string('address', 1024)->nullable();
            $table->string('reset_password_token')->nullable();
            $table->dateTime('reset_password_token_expire')->nullable();
            $table->rememberToken();
            $table->dateTime('cre_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('upd_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
