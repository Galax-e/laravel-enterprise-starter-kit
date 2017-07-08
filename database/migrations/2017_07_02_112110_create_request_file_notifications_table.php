<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestFileNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_file_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folder_request_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_roles')->unsigned()->default(2);
            $table->boolean('status')->default(0);
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
        Schema::drop('request_file_notifications');
    }
}
