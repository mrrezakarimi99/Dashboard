<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActiveCode extends Migration
{
    public function up()
    {
        Schema::table('active_code', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('code');
            $table->unique(['user_id' , 'code']);
            $table->timestamp('expired_at');
        });
    }

    public function down()
    {
        Schema::table('active_code', function (Blueprint $table) {
            //
        });
    }
}
