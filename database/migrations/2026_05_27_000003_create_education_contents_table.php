<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->default('article');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('video_url')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('read_count')->default(0);
            $table->unsignedInteger('estimated_minutes')->default(5);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_contents');
    }
};
