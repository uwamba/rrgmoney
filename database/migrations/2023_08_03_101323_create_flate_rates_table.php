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
        Schema::create('flate_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_amount');
            $table->bigInteger('to_amount');
            $table->bigInteger('charges_amount')->default(0);
            $table->bigInteger('charges_amount_percentage')->default(0);
            $table->bigInteger('charges_amount_percentage_cashout')->default(0);
            $table->bigInteger('charges_amount_cashout')->default(0);
            $table->bigInteger('currency_id');
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
        Schema::dropIfExists('flate_rates');
    }
};
