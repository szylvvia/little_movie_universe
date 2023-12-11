<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->string("surname", 50);
            $table->string("gender",10);
            $table->string("profession",20);
            $table->date("birth_date");
            $table->date("death_date")->nullable();
            $table->text("description")->nullable();
            $table->binary("image");
            $table->string("status",20)->default("pending");
            $table->unsignedBigInteger("user_id")->nullable();;
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement('ALTER TABLE artists MODIFY image MEDIUMBLOB;');
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
