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
        Schema::create('sightings', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('lat');
            $table->string('long');
            $table->string('optional_name')->nullable();
            $table->unsignedBigInteger('hunter_id')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->timestamps();

            $table->foreign('hunter_id')->references('id')->on('hunters')->onDelete('cascade');;
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sightings');
    }
};
