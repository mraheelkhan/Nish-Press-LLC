<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('magazine_id')->references('id')->on('magazines');
            $table->string('stripe_charge_id');
            $table->string('stripe_object');
            $table->string('stripe_balance_transaction');
            $table->json('stripe_billing_details');
            $table->json('stripe_payment_details');
            $table->string('stripe_receipt_url');
            $table->string('user_email');
            $table->string('transaction_created_at');
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
