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
            $table->integer('folder_id')->nullable();

            //$table->foreign('folder_id')->references('id')->on('folders')
            //->onUpdate('cascade')->onDelete('cascade');

            $table->string('from');
            $table->string('folder_name');
            $table->string('folder_desc');
			$table->boolean('treated')->default(0);
            $table->integer('receiver_role')->default(2);
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
