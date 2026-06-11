<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->string('request_number')->nullable()->after('user_id');
            $table->date('request_date')->nullable()->after('request_number');
            $table->string('department')->nullable()->after('request_date');
            $table->string('requester_title')->nullable()->after('department');
            $table->string('contact_number')->nullable()->after('requester_title');

            $table->longText('current_workflow')->nullable()->after('business_rules');
            $table->longText('expected_workflow')->nullable()->after('current_workflow');
            $table->longText('business_goal')->nullable()->after('expected_workflow');
            $table->longText('expected_benefits')->nullable()->after('business_goal');

            $table->longText('affected_menu')->nullable()->after('expected_benefits');
            $table->longText('field_changes')->nullable()->after('affected_menu');

            $table->longText('potential_risk')->nullable()->after('field_changes');
            $table->longText('priority_reason')->nullable()->after('potential_risk');
            $table->string('priority')->nullable()->after('priority_reason');

            $table->longText('validation_rules')->nullable()->after('priority');
            $table->longText('uiux_notes')->nullable()->after('validation_rules');
        });
    }

    public function down(): void
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn([

                'request_number',
                'request_date',
                'department',
                'requester_title',
                'contact_number',
                'current_workflow',
                'expected_workflow',
                'business_goal',
                'expected_benefits',
                'affected_menu',
                'field_changes',
                'potential_risk',
                'priority',
                'priority_reason',
                'validation_rules',
                'uiux_notes',
            ]);
        });
    }
};
