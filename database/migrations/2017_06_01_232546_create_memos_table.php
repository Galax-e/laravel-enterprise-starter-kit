<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('activities')){
            Schema::create('memos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email_name');
                $table->string('emailfrom');
                $table->string('emailto');
                $table->string('subject');
                $table->string('message');
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
        Schema::drop('memos');
    }
}
