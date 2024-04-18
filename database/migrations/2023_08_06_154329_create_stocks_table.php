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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->double('amount',15,2);
            $table->bigInteger('amount_deposit');
            $table->bigInteger('given_amount');
            $table->bigInteger('sequence_number');
            $table->string('currency');
            $table->integer('admin_id');
            $table->bigInteger('user_id');
            $table->string('status');
            $table->double('balance_before',15,2);
            $table->double('balance_after',15,2);
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
        Schema::dropIfExists('stocks');
    }
};
