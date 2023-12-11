<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->date("release_date");
            $table->text("description");
            $table->string("trailer_link", 255);
            $table->string("soundtrack_link", 255);
            $table->string("status")->default("pending");
            $table->binary("poster")->length(16777215);
            $table->unsignedBigInteger("user_id")->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('ALTER TABLE movies MODIFY poster MEDIUMBLOB;');
    }
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
