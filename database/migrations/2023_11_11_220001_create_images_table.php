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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("movie_id");
            $table->binary("image");
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE images MODIFY image MEDIUMBLOB;');
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
