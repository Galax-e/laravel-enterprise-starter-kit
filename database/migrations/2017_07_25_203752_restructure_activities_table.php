<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('activities', function($table){
            //$table->renameColumn('folder_id', 'element_desc');
            if(!Schema::hasColumn('activities', 'element_id')) {
               $table->integer('element_id')->after('type')->nullable()->default(0);
           }  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
