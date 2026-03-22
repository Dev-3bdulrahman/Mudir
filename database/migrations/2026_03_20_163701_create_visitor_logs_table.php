<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('ip_address')->nullable();
            $blueprint->string('country')->nullable();
            $blueprint->string('city')->nullable();
            $blueprint->text('user_agent')->nullable();
            $blueprint->string('device_type')->nullable(); // desktop, mobile, tablet
            $blueprint->string('browser')->nullable();
            $blueprint->string('platform')->nullable(); // windows, linux, ios, etc.
            $blueprint->string('url')->nullable();
            $blueprint->string('referrer')->nullable();
            $blueprint->boolean('is_unique')->default(false);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
