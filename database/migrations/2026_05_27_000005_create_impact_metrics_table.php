<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('total_user')->default(0);
            $table->unsignedInteger('total_journal')->default(0);
            $table->decimal('average_productivity', 5, 2)->default(0);
            $table->unsignedInteger('education_content_read')->default(0);
            $table->decimal('engagement_rate', 5, 2)->default(0);
            $table->timestamp('calculated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_metrics');
    }
};
