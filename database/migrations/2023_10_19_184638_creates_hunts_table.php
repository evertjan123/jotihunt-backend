<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hunts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('hunter_id')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->timestamps();

            $table->foreign('hunter_id')->references('id')->on('hunters')->onDelete('cascade');;
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
