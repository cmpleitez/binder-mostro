<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateRoleServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_service', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->unsignedBigInteger('role_id');
           $table->unsignedBigInteger('service_id');
           $table->timestamps();

           $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('role_service');
    }
}
