<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSharedbyToFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('folders', function($table){

           if(!Schema::hasColumn('folders', 'shared_by')) {
               $table->string('shared_by')->default('root@hallowgate.com')->after('desc');
           }  

           if(!Schema::hasColumn('folders', 'forwarded_by')) {
               $table->string('forwarded_by')->default('root@hallowgate.com')->after('shared_by');
           }

           if(Schema::hasColumn('folders', 'registry')) {
               $table->dropColumn('registry');
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
