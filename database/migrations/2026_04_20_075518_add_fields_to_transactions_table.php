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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('check_no')->nullable()->after('user_id');
            $table->string('office')->nullable()->after('check_no');
            $table->string('payee')->nullable()->after('office');
            $table->text('nature_of_payment')->nullable()->after('payee');
            $table->decimal('amount_issued', 10, 2)->nullable()->after('nature_of_payment');
            $table->string('account_code')->nullable()->after('amount_issued');
            $table->string('specific_fund')->nullable()->after('account_code');
            $table->enum('current_prior', ['Current', 'Prior', 'Continuing'])->nullable()->after('specific_fund');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['check_no', 'office', 'payee', 'nature_of_payment', 'amount_issued', 'account_code', 'specific_fund', 'current_prior']);
        });
    }
};
