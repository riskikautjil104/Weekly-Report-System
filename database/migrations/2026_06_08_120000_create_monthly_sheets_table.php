<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_sheets', function (Blueprint $table) {
            $table->id();
            $table->date('month')->unique();
            $table->string('title');
            $table->text('sheet_url');
            $table->string('sheet_gid')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_sheets');
    }
};
