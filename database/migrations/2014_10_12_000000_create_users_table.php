<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('surname', 50);
            $table->Date('birth_date');
            $table->string('email')->unique();
            $table->string('role',10)->default('user');
            $table->string('password');
            $table->text('description')->nullable();
            $table->binary('image')->nullable();
            $table->binary('background')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE users MODIFY image MEDIUMBLOB;');
        DB::statement('ALTER TABLE users MODIFY background MEDIUMBLOB;');
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
