<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivitybypostToActivities extends Migration
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

           if(!Schema::hasColumn('activities', 'activity_by_post')) {
               $table->string('activity_by_post')->nullable();
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
