<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('folder_id');

            $table->foreign('folder_id')->references('id')->on('folders')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('title');
            $table->string('name');
            $table->string('file_by');
            $table->integer('size')->unsigned();
            $table->string('type');
            $table->string('comment')->nullable();
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
        Schema::drop('documents');
    }
}
