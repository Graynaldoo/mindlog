<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moods', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // "Happy", "Sad", dll
            $table->string('emoji');      // "😊", "😢", dll
            $table->string('color');      // hex color untuk UI
            $table->integer('score');     // 1-5 untuk analitik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moods');
    }
};
