<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->unsignedInteger('durasi_menit');
            $table->text('alasan');
            $table->enum('status', ['submitted', 'approved', 'rejected'])->default('submitted');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('overtime_capture_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('overtime_request_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('image_hash', 64);
            $table->unsignedInteger('image_width');
            $table->unsignedInteger('image_height');
            $table->unsignedInteger('file_size_bytes');
            $table->string('camera_facing')->nullable();
            $table->text('device_user_agent');
            $table->string('ip_address', 45);
            $table->timestamp('captured_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtime_capture_metadata');
        Schema::dropIfExists('overtime_requests');
    }
};
