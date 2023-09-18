<?php


namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface FinanceServiceInterface
{
    public function getHistoricalData(Request $request);
}
