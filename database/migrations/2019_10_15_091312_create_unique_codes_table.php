<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueCodesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('unique_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_code')->unique();
            $table->ipAddress('visitor');
            $table->string('channel_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('unique_codes');
    }
}
