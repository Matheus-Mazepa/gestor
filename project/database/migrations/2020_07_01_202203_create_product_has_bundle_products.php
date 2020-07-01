<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHasBundleProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_has_bundle_products', function (Blueprint $table) {
            $table->integer('bundle_id')->nullable();
            $table->foreign('bundle_id')
                ->references('id')
                ->on('products');

            $table->integer('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_has_bundle_products');
    }
}
