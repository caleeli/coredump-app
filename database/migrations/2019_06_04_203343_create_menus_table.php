<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->char('id', 64);
            $table->char('parent', 64)->nullable();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
            $table->primary('id');
            $table->foreign('parent')->references('id')->on('menus')->onDelete('cascade');
        });
        Schema::create('menu_user', function (Blueprint $table) {
            $table->char('menu_id', 64);
            $table->bigIncrements('user_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_user');
    }
}
