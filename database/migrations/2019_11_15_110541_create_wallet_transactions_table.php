<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->double('amount');
            $table->enum('type', ['deposit', 'withdraw', 'refund', 'payout'])->index();
            $table->text('meta')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->after('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('transaction_type')->index()->after('type');
            $table->foreign('transaction_type')->references('id')->on('transactions_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
