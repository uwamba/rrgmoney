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
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->double('amount',15,2);
            $table->string('currency');
            $table->bigInteger('charges')->default(0);
            $table->string('payment_type');
            $table->string('reference');
            $table->string('agent')->nullable();
            $table->string('user_id');
            $table->double('balance_before',15,2)->default(0);
            $table->double('balance_after_temp',15,2)->default(0);
            $table->double('balance_after',15,2)->default(0);
            $table->string('status')->default("Pending");
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
        Schema::dropIfExists('topups');
    }
};
