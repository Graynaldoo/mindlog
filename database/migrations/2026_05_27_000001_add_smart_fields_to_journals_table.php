<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->text('daily_activities')->nullable()->after('content');
            $table->unsignedTinyInteger('productivity_score')->default(0)->after('daily_activities');
            $table->unsignedInteger('activity_minutes')->default(0)->after('productivity_score');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['daily_activities', 'productivity_score', 'activity_minutes']);
        });
    }
};
