<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role')->unique();
            $table->string('icon')->default('<i class="bx bx-chevron-right font-large-1"></i>');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
