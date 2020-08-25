<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_service', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("apartment_id");
            $table->foreign("apartment_id")
                ->references("id")
                ->on("apartments")
                ->onDelete('cascade');
            
            $table->foreignId("service_id");
            $table->foreign("service_id")
                ->references("id")
                ->on("services")
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_service');
    }
}
