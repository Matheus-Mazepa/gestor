<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();

            $table->integer('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->timestamp('date_to_production');

            $table->timestamps();
        });

        Schema::create('production_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('production_order_id');
            $table->foreign('production_order_id')
                ->references('id')
                ->on('production_orders');

            $table->integer('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->text('observation')->nullable();

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
        Schema::dropIfExists('production_order_items');
        Schema::dropIfExists('production_order');
    }
}
