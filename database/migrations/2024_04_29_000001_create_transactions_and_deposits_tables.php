<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $col) {
            $col->id();
            $col->foreignId('user_id')->constrained()->onDelete('cascade');
            $col->string('type'); // income/expense
            $col->decimal('amount', 15, 2)->default(0);
            $col->decimal('amount_issued', 15, 2)->default(0);
            $col->string('payee')->nullable();
            $col->string('check_no')->nullable();
            $col->text('nature_of_payment')->nullable();
            $col->string('specific_fund');
            $col->string('account_code')->nullable();
            $col->date('transaction_date');
            $col->string('status')->default('active');
            $col->timestamps();
        });

        Schema::create('deposits', function (Blueprint $col) {
            $col->id();
            $col->foreignId('user_id')->constrained()->onDelete('cascade');
            $col->decimal('amount', 15, 2);
            $col->string('cheque_number')->nullable();
            $col->string('payee')->nullable();
            $col->text('nature_of_payment')->nullable();
            $col->string('specific_fund');
            $col->date('deposit_date');
            $col->string('status')->default('active');
            $col->text('description')->nullable();
            $col->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('transactions');
    }
};