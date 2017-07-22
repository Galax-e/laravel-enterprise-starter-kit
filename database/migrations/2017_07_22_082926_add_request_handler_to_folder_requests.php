<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestHandlerToFolderRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
       Schema::table('folder_requests', function($table){

           if(!Schema::hasColumn('folder_requests', 'request_handler')) {
               $table->string('request_handler')->nullable();
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
        Schema::table('folder_requests', function($table) {
           $table->dropColumn('request_handler');
       });
    }
}
