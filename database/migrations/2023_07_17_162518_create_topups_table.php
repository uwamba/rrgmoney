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
            $table->bigInteger('amount');
            $table->string('currency');
            $table->bigInteger('charges')->default(0);
            $table->string('payment_type');
            $table->string('reference');
            $table->string('agent')->nullable();
            $table->string('user_id');
            $table->bigInteger('balance_before');
            $table->bigInteger('balance_after');
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
