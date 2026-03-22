<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->text('child_app_key')->nullable()->after('license_key');
            $table->longText('encrypted_modules')->nullable()->after('child_app_key');
        });
    }

    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn(['child_app_key', 'encrypted_modules']);
        });
    }
};
