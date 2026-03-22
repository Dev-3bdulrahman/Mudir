<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->id();
      $table->foreignId('client_id')->constrained()->cascadeOnDelete();
      $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
      $table->decimal('amount', 10, 2);
      $table->string('currency', 5)->default('SAR');
      $table->enum('status', ['pending', 'partial', 'paid'])->default('pending');
      $table->date('due_date')->nullable();
      $table->date('paid_date')->nullable();
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('invoices');
  }
};
