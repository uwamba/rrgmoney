<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('discount_amount')->default(0);
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sends', function($table) {
            $table->dropColumn('discount');
            $table->dropColumn('amount');
        });
    }
};
