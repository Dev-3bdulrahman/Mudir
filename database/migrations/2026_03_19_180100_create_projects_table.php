<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('client_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->enum('type', ['web', 'devops', 'content', 'n8n', 'other'])->default('web');
      $table->enum('status', ['draft', 'in_progress', 'review', 'completed', 'on_hold'])->default('draft');
      $table->text('description')->nullable();
      $table->string('preview_url')->nullable();
      $table->string('color')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('projects');
  }
};
