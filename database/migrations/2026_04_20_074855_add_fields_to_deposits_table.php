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
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('cheque_number')->nullable()->after('amount');
            $table->string('payee')->nullable()->after('cheque_number');
            $table->text('nature_of_payment')->nullable()->after('payee');
            $table->string('specific_fund')->nullable()->after('nature_of_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['cheque_number', 'payee', 'nature_of_payment', 'specific_fund']);
        });
    }
};
