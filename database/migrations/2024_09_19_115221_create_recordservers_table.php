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
        Schema::create('recordservers', function (Blueprint $table) {
            $table->id();
            $table->string('txhash')->nullable();
            $table->string('my_adress')->nullable();
            $table->string('from_adress')->nullable();
            $table->string('crypto_type')->nullable();
            $table->decimal('amount_crypto', 20, 7)->nullable();
            $table->decimal('satoshis', 20, 10)->nullable();
            $table->enum('status', ['Pending', 'Success', 'Failed'])->default('Pending'); // Status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recordservers');
    }
};
