<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentSponsorshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_sponsorship', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("apartment_id");
            $table->unsignedBigInteger("sponsorship_id");
            $table->timestamps();

            $table->foreign("apartment_id")
                ->references("id")
                ->on("apartments");
            $table->foreign("sponsorship_id")
                ->references("id")
                ->on("sponsorships");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_sponsorship');
    }
}
