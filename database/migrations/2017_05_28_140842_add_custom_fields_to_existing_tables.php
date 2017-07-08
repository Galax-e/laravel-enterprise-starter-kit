<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomFieldsToExistingTables extends Migration
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

            $colNames = ['position', 'middle_name', 'ministry', 'department', 'staff_code'];
            foreach ($colNames as $colName) {
                # code...
                if(!Schema::hasColumn('users', $colName)) {
                    //
                    $table->string($colName)->nullable();
                }
            }

            if(!Schema::hasColumn('users', 'avatar')) {
                //
                $table->string('avatar')->default('default-user.jpg');
            }            
        });

       
        Schema::table('password_resets', function (Blueprint $table) {

             if (!Schema::hasColumn('password_resets', 'created_at')) {
                $table->timestamps('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
            }
        });

        // have been moved to folderNotification
        // Schema::table('messages', function (Blueprint $table) {

        //      if (!Schema::hasColumn('messages', 'read')) {
        //         $table->boolean('read')->default(0)->change();
        //     }
        // });

        
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
