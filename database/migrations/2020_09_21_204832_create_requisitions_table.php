<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('offer_id');

            $table->string('supply_detail')->nullable();
            $table->unsignedInteger('supply_quantity');
            $table->decimal('supply_cost', 15, 6);
            $table->decimal('supply_charge', 15, 6);
            $table->decimal('requisition_charge', 15, 6);
            $table->decimal('requisition_amount', 15, 6);
            $table->boolean('invoiced')->default(0);
            $table->boolean('active')->default(1);

            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
