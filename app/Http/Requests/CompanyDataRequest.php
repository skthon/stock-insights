<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDataRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'symbol'     => 'required|exists:company_symbols,symbol',
            'email'      => 'required|email',
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:' . now()->format('Y-m-d'),
            'end_date'   => 'required|date|after_or_equal:start_date|before_or_equal:'. now()->format('Y-m-d'),
        ];
    }
}
