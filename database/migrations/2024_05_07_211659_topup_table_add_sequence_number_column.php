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
        if (Schema::hasColumn('topups','sequence_number'))
        {
            Schema::table('topups', function($table) {
                $table->dropColumn('sequence_number');
            });
        }
        Schema::table('topups', function (Blueprint $table) {
            $table->bigInteger('sequence_number')->default(0);
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sequence_number'))
        {
            Schema::table('topups', function($table) {
                $table->dropColumn('sequence_number');
            });
        }

    }
};
