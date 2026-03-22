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
    Schema::create('project_types', function (Blueprint $header) {
      $header->id();
      $header->json('name');
      $header->string('slug')->unique();
      $header->string('color')->default('#3b82f6');
      $header->string('icon')->default('package');
      $header->boolean('is_active')->default(true);
      $header->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('project_types');
  }
};
