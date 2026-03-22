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
        Schema::table('licensed_products', function (Blueprint $table) {
            $table->json('modules')->nullable()->after('dashboard_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licensed_products', function (Blueprint $table) {
            $table->dropColumn('modules');
        });
    }
};
