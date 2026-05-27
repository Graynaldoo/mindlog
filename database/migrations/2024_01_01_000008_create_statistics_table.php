<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('activity_date');
            $table->unsignedInteger('journals_count')->default(0);
            $table->unsignedInteger('articles_read')->default(0);
            $table->unsignedInteger('learning_minutes')->default(0);
            $table->unsignedInteger('digital_literacy_score')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'activity_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
