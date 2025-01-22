<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            // First, add the column without constraints
            $table->unsignedBigInteger('deposit_id')->nullable(); // Make nullable if needed

            // Add the foreign key constraint separately
            $table->foreign('deposit_id')
                  ->references('id')
                  ->on('deposits')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['deposit_id']);
            // Then drop the column
            $table->dropColumn('deposit_id');
        });
    }
};
