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
        Schema::create('agent_cash_out', function (Blueprint $table) {
                           $table->id();
                           $table->bigInteger('amount');
                           $table->string('method');
                           $table->string('admin_id');
                           $table->string('user_id')->nullable();
                           $table->string('status');
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
        Schema::dropIfExists('agent_cash_out');
    }
};
