<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('due_date');
            $table->integer('value');
            $table->string('description');
            $table->boolean('paid_or_schedule')->default(false);

            $table->integer('payment_form_id');
            $table->foreign('payment_form_id')
                ->references('id')
                ->on('payment_forms');

            $table->integer('company_id');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

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
        Schema::dropIfExists('bills');
    }
}
