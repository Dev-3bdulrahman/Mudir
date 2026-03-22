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
    Schema::create('contract_templates', function (Blueprint $table) {
      $table->id();
      $table->json('title');
      $table->json('content'); // Store clauses as array of paragraphs/blocks
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    Schema::create('contracts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('client_id')->constrained()->onDelete('cascade');
      $table->foreignId('contract_template_id')->nullable()->constrained()->onDelete('set null');
      $table->string('contract_number')->unique();
      $table->json('title');
      $table->json('content'); // Final snapshots of clauses
      $table->enum('status', ['draft', 'sent', 'signed', 'cancelled'])->default('draft');
      $table->timestamp('signed_at')->nullable();
      $table->date('expires_at')->nullable();
      $table->decimal('total_amount', 15, 2)->nullable();
      $table->string('currency', 10)->default('USD');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('contracts');
    Schema::dropIfExists('contract_templates');
  }
};
