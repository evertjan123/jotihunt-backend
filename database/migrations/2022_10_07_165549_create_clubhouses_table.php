<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubhouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('accomodation');
            $table->string('street');
            $table->integer('housenumber');
            $table->string('housenumber_addition')->nullable();
            $table->string('postcode');
            $table->string('lat');
            $table->string('long');
            $table->integer('photo_assignment_points')->nullable();
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
        Schema::dropIfExists('clubhouses');
    }
};
