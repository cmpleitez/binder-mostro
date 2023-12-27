<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('payment_type_id')->default(1);
            $table->unsignedBigInteger('square_id')->nullable();
            
            $table->decimal('amount', 15, 6);
            $table->decimal('tax', 15, 6);
            $table->string('voucher')->nullable();
            $table->boolean('purchased')->default(0);
            $table->boolean('invoiced')->default(0);
            $table->boolean('closed')->default(0);
            $table->boolean('autoservicio')->default(1);
            
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('square_id')->references('id')->on('squares');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}