<?php

namespace App\Services;

use App\Services\Interfaces\FinanceServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class YahooFinanceService implements FinanceServiceInterface
{
    private function getUrl(): string
    {
        return 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';
    }

    private function getHeaders(): array
    {
        return [
            'X-RapidAPI-Key'  => config('finance_services.yahoo_finance.api_key'),
            'X-RapidAPI-Host' => config('finance_services.yahoo_finance.hostname'),
        ];
    }

    private function sendRequest(Request $request): Response
    {
        $headers = $this->getHeaders();
        if (! isset($headers['X-RapidAPI-Key'])) {
            Log::error('[yahoo-finance] RapidApi key not set in environment');
            throw new Exception("Internal error");
        }

        return Http::withHeaders($headers)
            ->get($this->getUrl() . '?'. http_build_query([
                'symbol' => $request->get('symbol'),
                'region' => $request->get('region', 'US'),
            ]));
    }

    public function getHistoricalData(Request $request): array
    {
        $response = $this->sendRequest($request);
        $data = json_decode($response->body(), true);

        if ($response->status() != 200) {
            Log::error('[yahoo-finance] Failed to fetch response. status:' . $response->status() . ' response:' . $response->body());
            throw new Exception('Failed to fetch response');
        }

        return $this->filterData(
            $data['prices'],
            $request->get('start_date'),
            $request->get('end_date')
        );
    }

    private function filterData(array $prices, $startDate, $endDate): array
    {
        list($start, $end) = [strtotime($startDate), strtotime($endDate)];
        $filteredData = [];

        $prev = [];
        foreach($prices as $price) {
            if ($price['date'] >= $start && $price['date'] <= $end) {
                $data = collect($price)->only([
                    'date', 'open', 'high', 'low', 'close', 'volume'
                ])->toArray();
                $data['date'] = date('Y-m-d', $data['date']);

                $filteredData[] = ! isset($data['open'])
                    ? array_merge($prev, ['date' => date('Y-m-d', $price['date'])])
                    : $data;

                $prev = $data;
            }
        }

        return $filteredData;
    }
}
