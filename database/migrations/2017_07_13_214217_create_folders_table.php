<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->nullable();
            $table->string('name'); //fold_name
            $table->string('desc'); // folder_desc
            $table->string('registry');
            $table->string('folder_by');
            $table->string('agency_dept');
            $table->string('folder_to');
            $table->string('category');
            $table->integer('clearance_level')->unsigned();
            $table->string('latest_doc');
            $table->string('search_term')->nullable(); // folder_search
            $table->string('last_comment')->nullable();
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
        Schema::drop('folders');
    }
}
