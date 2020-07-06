<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->length(11);
            $table->string('username',255);
            $table->string('password',255);
            $table->string('fullname',255);
            $table->string('email',255);
            $table->string('remember_token',125)->nullable(true);
            $table->integer('status')->length(1)->default(1);
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
        Schema::dropIfExists('sys_users');
    }
}
