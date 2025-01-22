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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->string('plan');
            $table->decimal('amount', 20, 7); // Deposit amount
            $table->string('crypto_type'); // Type of cryptocurrency
            $table->decimal('amount_crypto', 20, 7)->nullable(); // Amount in cryptocurrency
            $table->enum('status', ['Pending', 'Success', 'Failed'])->default('Pending'); // Status
            $table->uuid('transaction_id')->unique(); // Unique identifier
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
