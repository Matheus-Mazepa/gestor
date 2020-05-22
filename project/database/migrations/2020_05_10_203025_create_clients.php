<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('ie_municipal')->nullable();
            $table->string('ie_estadual')->nullable();
            $table->boolean('is_legal_person');
            $table->string('cpf_cnpj');

            $table->integer('company_id');
            $table->foreign('company_id')
            ->references('id')
            ->on('companies');

            $table->integer('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');

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
        Schema::dropIfExists('clients');
    }
}
