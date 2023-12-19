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
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->bigInteger('charges')->default(0);
            $table->string('method');
            $table->string('currency');
            $table->string('details')->nullable();
            $table->string('location')->nullable();
            $table->string('user_id')->nullable();
            $table->string('receiver_id');
            $table->string('transfer_id')->default("Requested");
            $table->string('admin_message')->nullable();
            $table->bigInteger('balance_before');
            $table->bigInteger('balance_after');
            $table->string('status')->default("Requested");
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
        Schema::dropIfExists('cashouts');
    }
};
