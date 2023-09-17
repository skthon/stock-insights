<?php

namespace App\Console\Commands;

use App\Models\CompanySymbol;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;

class ImportCompanySymbols extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company_symbols:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for importing company symbol information';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Company symbols source
        $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';

        try {
            $response = Http::get($url);
        } catch (Exception $ex) {
            $this->error('Failed fetching company symbols. Message: ' . $ex->getMessage());
            return Command::FAILURE;
        }

        if ($response->status() != 200) {
            return Command::FAILURE;
        }

        $companySymbols = json_decode($response->body(), true);
        $inserted = 0;

        // TODO: insert in chunks
        foreach ($companySymbols as $data) {
            $match = ['symbol' => $data['Symbol']];
            CompanySymbol::updateOrCreate($match, [
                'company_name'     => $data['Company Name'],
                'financial_status' => $data['Financial Status'],
                'market_category'  => $data['Market Category'],
                'round_lot_size'   => $data['Round Lot Size'],
                'security_name'    => $data['Security Name'],
                'symbol'           => $data['Symbol'],
                'test_issue'       => $data['Test Issue'],
            ]);
            $inserted++;
        }

        $this->info("Inserted $inserted company symbol records");
        return Command::SUCCESS;
    }
}
