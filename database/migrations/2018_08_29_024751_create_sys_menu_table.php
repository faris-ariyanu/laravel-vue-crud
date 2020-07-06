<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',125);
            $table->string('url',125)->nullable(true);
            $table->integer('sequence')->length(11)->default(0);
            $table->integer('parent')->length(11)->default(0);
            $table->text('menu_value')->nullable(true);
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
        Schema::dropIfExists('sys_menu');
    }
}
