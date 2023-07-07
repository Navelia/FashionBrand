<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDimensionColumnTransactionsProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions_products', function (Blueprint $table) {
            $table->string('dimension', 45)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_products', function (Blueprint $table) {
            $table->dropColumn('dimension');
        });
    }
}
