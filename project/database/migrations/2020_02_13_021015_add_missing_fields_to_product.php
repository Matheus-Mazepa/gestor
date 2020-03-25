<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingFieldsToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('price_nfc');
            $table->string('taxable_unit');
            $table->integer('cfop_nfc');
            $table->integer('cfop_nfe');
            $table->integer('quantity')->default(0);
            $table->integer('minimal_quantity');
            $table->integer('taxable_quantity');
            $table->integer('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price_nfc');
            $table->dropColumn('taxable_unit');
            $table->dropColumn('cfop_nfc');
            $table->dropColumn('cfop_nfe');
            $table->dropColumn('quantity');
            $table->dropColumn('minimal_quantity');
            $table->dropColumn('taxable_quantity');
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
}
