<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPinToUsers extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       //
       Schema::table('users', function($table){

           if(!Schema::hasColumn('users', 'pin')) {
               $table->string('pin')->default('0000');
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
       Schema::table('users', function($table) {
           $table->dropColumn('pin');
       });
   }
}