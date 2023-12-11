<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question',255);
            $table->binary("image")->length(16777215);
            $table->unsignedBigInteger("quiz_id")->nullable();
            $table->timestamps();
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE questions MODIFY image MEDIUMBLOB;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
