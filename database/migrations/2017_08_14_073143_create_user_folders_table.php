<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_folders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');            
            $table->unsignedInteger('passer_id');
            $table->unsignedInteger('folder_id');
            $table->integer('status')->default(0);
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
        Schema::drop('user_folders');
    }
}
