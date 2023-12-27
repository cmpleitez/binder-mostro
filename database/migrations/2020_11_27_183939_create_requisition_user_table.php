<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionUserTable extends Migration
{
    public function up()
    {
        Schema::create('requisition_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('requisition_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('area_id');
            $table->boolean('processed')->default(0);
            $table->boolean('inspected')->default(0);
            $table->boolean('active')->default(1);
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('requisition_id')->references('id')->on('requisitions');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisition_user');
    }
}
