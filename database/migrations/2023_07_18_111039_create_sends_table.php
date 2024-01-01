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
        Schema::create('sends', function (Blueprint $table) {
            $table->id();
            $table->double('amount_foregn_currency',15,2);
            $table->double('charges',15,2)->default(0);;
            $table->string('currency');
            $table->string('reception_method');
            $table->string('class');
            $table->double('amount_local_currency',15,2);
            $table->string('local_currency');
            $table->longText('description');
            $table->string('names');
            $table->string('passport');
            $table->string('email');
            $table->string('phone');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('user_id');
            $table->double('balance_before',15,2)->default(0);
            $table->double('balance_after',15,2)->default(0);
            $table->double('balance_after_temp',15,2)->default(0);
            $table->string('status')->default("Pending");
            $table->timestamps();
            $table->string('passcode');
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->integer('unread')->default(1);
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sends');
    }
};
