<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('photo');
            $table->longText('description');
            $table->float('joining_fee');
            $table->integer('max_user');
            $table->integer('joined_user');
            $table->dateTime('execution_date');
            $table->timestamps();
        });

        Schema::table('contests', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('type');
            $table->foreign('type')->references('id')->on('contest_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
