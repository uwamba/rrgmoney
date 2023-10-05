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
            $table->bigInteger('amount');
            $table->bigInteger('amount_deposit');
            $table->bigInteger('given_amount');
            $table->string('currency');
            $table->integer('admin_id');
            $table->bigInteger('user_id');
            $table->string('status')->unique();
            $table->bigInteger('balance_before');
            $table->bigInteger('balance_after');
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
