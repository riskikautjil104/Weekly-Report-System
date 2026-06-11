<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->json('summary_json')->nullable()->after('status');
            $table->json('activities_json')->nullable()->after('summary_json');
            $table->json('issues_json')->nullable()->after('activities_json');
            $table->timestamp('archived_at')->nullable()->after('issues_json');
            $table->unique(['user_id', 'week_start', 'week_end'], 'weekly_reports_user_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->dropUnique('weekly_reports_user_period_unique');
            $table->dropColumn(['summary_json', 'activities_json', 'issues_json', 'archived_at']);
        });
    }
};
