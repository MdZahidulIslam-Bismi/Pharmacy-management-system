<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockproducts', function (Blueprint $table) {
            $table->id();
            $table->text('stock_invoice_id');
            $table->bigInteger('product_id')->unsigned(); 
            $table->string('stock_product_desc')->nullable();
            $table->bigInteger('stock_quantity')->unsigned();
            $table->bigInteger('stock_buy_price')->unsigned();
            $table->bigInteger('stock_payment')->unsigned();
            $table->bigInteger('stock_sell_price')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockproducts');
    }
}
