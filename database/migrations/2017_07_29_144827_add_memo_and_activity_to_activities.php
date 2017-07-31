<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemoAndActivityToActivities extends Migration
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
            
            if(!Schema::hasColumn('activities', 'memo')) {
               $table->string('memo')->nullable();
           }  

            if(!Schema::hasColumn('activities', 'activity_to')) {
                $table->string('activity_to')->nullable();
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
