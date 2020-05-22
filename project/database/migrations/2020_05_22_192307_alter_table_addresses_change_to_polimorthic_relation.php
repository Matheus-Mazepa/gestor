<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddressesChangeToPolimorthicRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            $table->morphs('address_owner');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropColumn('address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('company_id')->nullable()->unsigned();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropMorphs('address_owner');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->integer('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
        });
    }
}
