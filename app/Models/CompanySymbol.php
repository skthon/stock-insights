<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySymbol extends Model
{
    use HasUUID, HasFactory;

    protected $fillable = [
        'company_name',
        'financial_status',
        'market_category',
        'round_lot_size',
        'security_name',
        'symbol',
        'test_issue',
    ];
}
