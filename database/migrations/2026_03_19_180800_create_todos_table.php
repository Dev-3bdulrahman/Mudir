<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('todos', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
      $table->string('title');
      $table->text('description')->nullable();
      $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
      $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
      $table->date('due_date')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('todos');
  }
};
