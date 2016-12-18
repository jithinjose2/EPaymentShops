<?php

namespace EPaymentShops\Console\Commands;

use EPaymentShops\Repository\GridScanner;
use EPaymentShops\Repository\Scrappers\PayTm;
use Illuminate\Console\Command;

class PayTMScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:paytm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PayTM Merchant scrapping on next available grid';

    protected $crawlBase = "curl 'https://paytm.com/v1/api/getnearbysellers?child_site_id=1&site_id=1' -H 'Cookie: tvc_vid=21476709254372; tvc_banner_tracking_cookie=Flights $ Flights; referrer=; XSRF-TOKEN=7eQFp9dW-T5VVZAGqn_752oJCbbLObGtY3D4; _ampUSER=eyJjdXN0b21lcl9pZCI6IjczMDU5MSJ9; _ampNV=1; queenoftarts=pawslmktshopapp68; connect.sid=s%3AbGkJ0xEtY5uo-YtDk2cL-83toTQQ6BW-.82wZNhKg4IKnalHhPQ2kwOgD%2F6lSyeE%2FwT45bqJoNqE; _ga=GA1.2.968722806.1476709254' -H 'Origin: https://paytm.com' -H 'X-XSRF-TOKEN: 7eQFp9dW-T5VVZAGqn_752oJCbbLObGtY3D4' -H 'Accept-Language: en-US,en;q=0.8' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.100 Safari/537.36' -H 'Content-type: application/json' -H 'Accept: application/json, text/plain, */*' -H 'Referer: https://paytm.com/nearby' -H 'Accept-Encoding: gzip, deflate, br' -H 'Connection: keep-alive' --data-binary '<data binary>' --compressed";

    protected $searchQuery = [
        'distance' => 11.1,
        'endLimit' => 20000,
        'latitude' => 12.9,
        'longitude' => 77.5,
        'searchFilter' => [[
            'filterType' => 'SERVICE',
            'value' => 'PAYMENT_POINT'
        ]],
        'sortBy' => [
            'DISTANCE_WISE_SORT' => 'ASC'
        ],
        "startLimit" => 0,
        "channel" => "web",
        "version" => 2
    ];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PayTm $payTm, GridScanner $gridScanner)
    {
        $this->payTm = $payTm;
        $this->gridScanner = $gridScanner;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        while($grid = $this->gridScanner->getNextGrid()) {
            //if($this->ask('Scan grid ['.$grid->lat.','.$grid->lng.'] ?')) {

                $this->line(' ');
                $this->info('Scanning Grid grid ['.$grid->lat.','.$grid->lng.']');
                $request = $this->searchQuery;
                $request['latitude'] = $grid->lat;
                $request['longitude'] = $grid->lng;

                $response = $this->scrapGrid($request);
                $storeCount = $this->processResponse($response);

                $this->gridScanner->updateScanResult($grid, $storeCount, $request, $response);
                $this->warn('Scanning Complete : STORES : ' . $storeCount);
                $grid = null;
            //}
        }
    }

    public function scrapGrid($data)
    {
        $str = json_encode($data);
        return json_decode(exec(str_replace('<data binary>', $str, $this->crawlBase)), true);
    }

    private function processResponse($response)
    {
        $shops  = false;
        $lastDistance = 0;
        if (is_array($response) && !empty($response['response'])) {
            $response = $response['response'];
            $shops = 0;
            if (is_array($response) && count($response) > 0) {
                $this->line('Response Valid, Store Count : ' . count($response));
                foreach ($response as $shopNewData) {
                    try {
                        $shop = $this->payTm->addNewUpdate($shopNewData);
                    } catch (\Exception $e) {}
                    if ($shop) {
                        $shops++;
                        $lastDistance = round($shopNewData['distanceFromLocation'], 2);
                        //$this->info('New Shop added : ' . $shop->id . ' DISTANCE : ' . round($shopNewData['distanceFromLocation'], 2) . ' NAME: ' . $shop->name);
                    } else {
                        //$this->error($shopNewData);
                    }
                }
            }
        }
        $this->line('Last Distance : ' . $lastDistance);
        return $shops;
    }
}
