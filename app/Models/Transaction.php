<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const SPECIFIC_FUNDS = [
        'GENERAL FUND PROPER',
        'SPECIAL EDUCATION FUND',
        '20% DEVELOPMENT FUND',
        'ECONOMIC ENTERPRISE',
        'TRUST FUNDS 0962-1000-23',
        'TRUST FUNDS 1962-1052-62',
        'TRUST FUNDS 1962-1083-50',
        'TRUST FUNDS 1962-1006-35',
    ];

    protected $fillable = [
        'user_id',
        'check_no',
        'office',
        'payee',
        'nature_of_payment',
        'amount_issued',
        'account_code',
        'specific_fund',
        'current_prior',
        'amount',
        'type',
        'description',
        'transaction_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
            'amount_issued' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
