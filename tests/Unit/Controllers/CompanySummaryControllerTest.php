<?php

namespace Tests\Unit\Controllers;

use App\Models\CompanySymbol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CompanySummaryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_form_with_empty_values()
    {
        $response = $this->post('/company/history');
        $response->assertSessionHasErrors(['symbol', 'email', 'start_date', 'end_date']);
    }

    public function test_submit_form_with_invalid_symbol()
    {
        $response = $this->post('/company/history', [
            'symbol' => 'Test'
        ]);
        $response->assertSessionHasErrors('symbol');
    }

    public function test_submit_form_with_valid_symbol()
    {
        CompanySymbol::factory()->create(['symbol' => 'TEST']);
        $response = $this->post('/company/history', [
            'symbol' => 'Test'
        ]);
        $response->assertSessionMissing('symbol');
    }

    public function test_submit_form_with_invalid_email()
    {
        $response = $this->post('/company/history', [
            'email' => 'invalid-email'
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function test_submit_form_with_valid_email()
    {
        $response = $this->post('/company/history', [
            'symbol' => 'test@example.net'
        ]);
        $response->assertSessionMissing('email');
    }

    public function test_submit_form_with_invalid_date_inputs()
    {
        CompanySymbol::factory()->create(['symbol' => 'TEST']);
        $response = $this->post('/company/history', [
            'symbol'     => 'TEST',
            'email'      => 'test@example.net',
            'start_date' => '2022-01-01',
            'end_date'   => '2021-12-31',
        ]);

        $response->assertSessionHasErrors([
            'start_date' => 'The start date must be a date before or equal to end date.',
            'end_date'   => 'The end date must be a date after or equal to start date.',
        ]);

        $response = $this->post('/company/history', [
            'symbol'     => 'TEST',
            'email'      => 'saikiran@gmail.com',
            'start_date' => now()->addDays(15)->format('Y-m-d'),
            'end_date'   => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors([
            'start_date' => 'The start date must be a date before or equal to ' . now()->format('Y-m-d') . '.',
            'end_date'   => 'The end date must be a date before or equal to ' . now()->format('Y-m-d') . '.',
        ]);
    }

    public function test_submit_form_successful()
    {
        Mail::fake();
        $companySymbol = CompanySymbol::factory()->create(['symbol' => 'TEST']);

        Http::fake([
            'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=TEST&region=US' => Http::response([
            "prices" => [
                [
                    "date"  => now()->subDays(10)->getTimestamp(),
                    "open"  => 1,
                    "high"  => 1.0099999904632568,
                    "low"   => 0.9900000095367432,
                    "close" => 1.0099999904632568,
                    "volume" => 1147000,
                ],
            ]], 200),
        ]);

        $response = $this->post('/company/history', [
            'symbol'     => 'TEST',
            'email'      => 'saikiran@gmail.com',
            'start_date' => now()->subDays(15)->format('Y-m-d'),
            'end_date'   => now()->subDays(5)->format('Y-m-d'),
        ]);

        $response->assertViewHas([
            'prices' => [[
                "date"   => now()->subDays(10)->format('Y-m-d'),
                "open"   => 1,
                "high"  => 1.0099999904632568,
                "low"   => 0.9900000095367432,
                "close" => 1.0099999904632568,
                "volume" => 1147000,
            ]],
            "symbol"    => $companySymbol->symbol,
            "name"      => $companySymbol->name,
            'startDate' => now()->subDays(15)->format('Y-m-d'),
            'endDate'   => now()->subDays(5)->format('Y-m-d'),
        ]);
    }
}
