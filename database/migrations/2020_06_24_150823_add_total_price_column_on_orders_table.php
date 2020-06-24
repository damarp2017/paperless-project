<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceColumnOnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_price')->nullable()->after('discount');
            $table->integer('total_discount_by_percent')->nullable()->after('total_price');
            $table->integer('total_price_with_discount')->nullable()->after('total_discount_by_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_price');
            $table->dropColumn('total_discount_by_price');
            $table->dropColumn('total_price_with_discount');
        });
    }
}
