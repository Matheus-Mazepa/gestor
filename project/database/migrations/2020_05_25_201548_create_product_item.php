<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');

            $table->integer('payment_form_id');
            $table->foreign('payment_form_id')
                ->references('id')
                ->on('payment_forms');

            $table->timestamps();
        });

        Schema::create('product_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');

            $table->integer('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->integer('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_item');
    }
}
