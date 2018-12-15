<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transactions', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('transaction_id')->unique()->unsigned()->nullable();
      $table->integer('amount')->unsigned();
      $table->string('token')->unique();
      $table->string('card_number')->nullable();
      $table->boolean('status')->default(0);
      $table->boolean('verify_status')->default(0);
      $table->timestamps();
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
