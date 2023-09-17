<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyDataRequest;
use App\Models\CompanySymbol;
use App\Services\Interfaces\FinanceServiceInterface;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class CompanySummaryController extends Controller
{
    public function __construct(public readonly FinanceServiceInterface $financeService){

    }

    public function showForm()
    {
        return view('company_form');
    }

    public function submitForm(CompanyDataRequest $companyDataRequest)
    {
        $companySymbol = CompanySymbol::where(
            'symbol', '=', strtoupper($companyDataRequest->get('symbol'))
        )->first();

        $data = $this->financeService->getHistoricalData($companyDataRequest);
        $this->sendEmail($companyDataRequest, $companySymbol);

        try {
            return view('company_summary', [
                'prices'     => $data,
                'symbol'     => $companySymbol->symbol,
                'name'       => $companySymbol->company_name,
                'startDate' => $companyDataRequest->get('start_date'),
                'endDate'   => $companyDataRequest->get('end_date'),
            ]);
        } catch (Exception $ex) {
            return back()->withErrors(['message' => 'Internal error, please try again after sometime'])->withInput();
        }
    }

    private function sendEmail(CompanyDataRequest $companyDataRequest, CompanySymbol $companySymbol)
    {
        $mailData = [
            'startDate' => $companyDataRequest->get('start_date'),
            'endDate'   => $companyDataRequest->get('end_date')
        ];
        Mail::send('emails.company', $mailData, function($message) use ($companyDataRequest, $companySymbol) {
            $message->to($companyDataRequest->get('email'))
                ->subject('Submitted company - ' . $companySymbol->name);
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
