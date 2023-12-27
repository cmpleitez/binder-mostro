<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_type_id');

            $table->string('service')->unique();
            $table->string('icon')->default('<i class="bx bx-chevron-right font-large-1"></i>');
            $table->string('pic')->nullable();
            $table->string('route')->nullable();
            $table->decimal('cost', 15, 6);
            $table->decimal('charge', 15, 6);

            $table->boolean('tax_exempt')->default(0);
            $table->boolean('menu')->default(0);
            $table->boolean('private_net')->default(1);
            $table->boolean('billable')->default(0);
            $table->boolean('active')->default(1);

            $table->foreign('service_type_id')->references('id')->on('service_types');
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
        Schema::dropIfExists('services');
    }
}
