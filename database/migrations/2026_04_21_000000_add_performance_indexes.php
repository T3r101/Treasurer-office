<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add indexes for frequently queried columns to improve performance
     */
    public function up(): void
    {
        // Transactions table indexes
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('transaction_date');
            $table->index('specific_fund');
            $table->index('type');
            $table->index('status');
            $table->index(['user_id', 'transaction_date']);
            $table->index(['user_id', 'type', 'status']);
        });

        // Deposits table indexes
        Schema::table('deposits', function (Blueprint $table) {
            $table->index('deposit_date');
            $table->index('specific_fund');
            $table->index('status');
            $table->index(['user_id', 'deposit_date']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['transaction_date']);
            $table->dropIndex(['specific_fund']);
            $table->dropIndex(['type']);
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'transaction_date']);
            $table->dropIndex(['user_id', 'type', 'status']);
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->dropIndex(['deposit_date']);
            $table->dropIndex(['specific_fund']);
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'deposit_date']);
            $table->dropIndex(['user_id', 'status']);
        });
    }
};
