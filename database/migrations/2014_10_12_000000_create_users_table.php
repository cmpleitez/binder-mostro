<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('area_id');

            $table->integer('dui')->unsigned()->nullable();
            $table->bigInteger('nit')->unsigned()->nullable();
            $table->Integer('nrc')->unsigned()->nullable();
            $table->bigInteger('phone_number')->unsigned()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->index('nrc');
            $table->index('nit');
            $table->index('phone_number');
            $table->boolean('cashbox_open')->default(1);
            $table->boolean('autoservicio')->default(1);
            $table->boolean('active')->default(1);

            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
