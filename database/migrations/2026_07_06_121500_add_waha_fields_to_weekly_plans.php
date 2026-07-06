<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('weekly_plans', function (Blueprint $table) {
            $table->string('waha_chat_id')->nullable()->after('description');
            $table->boolean('sent_to_whatsapp')->default(false)->after('waha_chat_id');
            $table->timestamp('waha_sent_at')->nullable()->after('sent_to_whatsapp');
            $table->text('waha_send_error')->nullable()->after('waha_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('weekly_plans', function (Blueprint $table) {
            $table->dropColumn(['waha_chat_id', 'sent_to_whatsapp', 'waha_sent_at', 'waha_send_error']);
        });
    }
};
