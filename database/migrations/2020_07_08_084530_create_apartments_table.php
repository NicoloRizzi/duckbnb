<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->string("title");
            $table->text("description");
            $table->decimal("price", 6, 2);
            $table->tinyInteger("room_qty")->unsigned();
            $table->tinyInteger("bathroom_qty")->unsigned();
            $table->tinyInteger("bed_qty")->unsigned();
            $table->smallInteger("sqr_meters")->unsigned();
            $table->boolean("is_visible");
            $table->string("img_url");
            $table->decimal("lat", 10, 8);
            $table->decimal("lng", 11, 8);
            $table->smallInteger("views")->unsigned();

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
        Schema::dropIfExists('apartments');
    }
}
