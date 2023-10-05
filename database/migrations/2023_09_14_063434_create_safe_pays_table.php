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
        Schema::create('safe_pays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount_foregn_currency');
            $table->bigInteger('charges')->default(0);
            $table->string('currency');
            $table->string('reception_method');
            $table->bigInteger('amount_local_currency');
            $table->string('names');
            $table->string('passport');
            $table->string('email');
            $table->string('phone');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('user_id');
            $table->bigInteger('balance_before');
            $table->bigInteger('balance_after');
            $table->string('status')->default("onhold");
            $table->timestamps();
            $table->string('passcode');
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->integer('unread')->default(1);
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('attachement')->nullable();
            $table->string('reason')->nullable();
            $table->string('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('safe_pays');
    }
};
