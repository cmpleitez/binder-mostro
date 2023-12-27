<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTypesTable extends Migration
{
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type')->unique();
            $table->boolean('cashbox_in');
            $table->boolean('active')->default(1);

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
        Schema::dropIfExists('payment_types');
    }
}
