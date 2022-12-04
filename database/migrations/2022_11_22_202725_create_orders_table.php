<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('tour_id');
            $table->string('phone');
            $table->string('email');
            $table->tinyInteger('payment_method');
            $table->double('total_amount', 10, 2);
            $table->integer('discount');
            $table->dateTime('payment_date');
            $table->tinyInteger('published')->default(1);
            $table->string('comment')->nullable();
            $table->double('payment_amount', 10, 2);
            $table->string('payment_currency');
            $table->integer('order_number');
            $table->integer('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
