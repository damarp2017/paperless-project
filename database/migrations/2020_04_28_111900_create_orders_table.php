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
            $table->unsignedBigInteger('sell_by_store');
            $table->unsignedBigInteger('buy_by_user')->nullable();
            $table->unsignedBigInteger('buy_by_store')->nullable();
            $table->integer('discount')->default(0);
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sell_by_store')->references('id')->on('stores');
            $table->foreign('buy_by_user')->references('id')->on('users');
            $table->foreign('buy_by_store')->references('id')->on('stores');
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
