<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // weekly_reports dibuat pada migration lain.
            // Agar migrate tidak gagal karena urutan, FK constraint dibentuk di migration tersendiri.
            $table->foreignId('weekly_report_id')->nullable();

            // required oleh app rules/model
            $table->date('tanggal');
            $table->text('aktivitas');
            $table->enum('status', ['selesai', 'progress', 'kendala']);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
