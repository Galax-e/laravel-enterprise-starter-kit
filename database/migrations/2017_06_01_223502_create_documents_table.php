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

        if(!Schema::hasTable('activities')){

            Schema::create('documents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('folder_id')->unsigned();
                $table->string('title');
                $table->string('name');
                $table->string('file_by');
                $table->integer('size')->unsigned();
                $table->string('type');
                $table->timestamps();
            });
        }

        
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
