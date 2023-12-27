<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('service_id');
            
            $table->decimal('cost', 15, 6);
            $table->unsignedInteger('supplied_quantity');
            $table->unsignedInteger('stock_quantity');
            $table->boolean('income');
            $table->boolean('active')->default(1);
            $table->timestamps();
            
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_service');
    }
}
