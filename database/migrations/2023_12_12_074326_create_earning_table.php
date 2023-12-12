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
        Schema::create('earning', function (Blueprint $table) {
                           $table->id();
                           $table->bigInteger('amount');
                           $table->string('currency');
                           $table->string('entry_type');
                           $table->string('description');
                           $table->string('user_id')->nullable();
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
        Schema::dropIfExists('earning');
    }
};
