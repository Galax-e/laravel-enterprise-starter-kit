<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('folder_id');

            $table->foreign('folder_id')->references('id')->on('folders')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->string('from');
            $table->string('name');
            $table->string('desc');
            $table->string('registry');
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
        Schema::drop('folder_requests');
    }
}
