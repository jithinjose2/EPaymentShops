<?php

namespace EPaymentShops\Repository;

use EPaymentShops\Models\GridScanLog;
Use EPaymentShops\Models\Grid;
use \Illuminate\Support\Facades\Storage;
/**
 * Created by PhpStorm.
 * User: jithin
 * Date: 18/12/16
 * Time: 3:39 PM
 */
class GridScanner
{

    public $serviceName = 'paytm';

    public function getNextGrid()
    {
        return Grid::where('processed', 0)
            ->orderBy('priority', 'desc')
            ->orderBy('id')
            ->first();
    }

    public function updateScanResult($grid, $count, $request, $response)
    {
        $grid->processed = 1;
        $grid->store_count = $count;
        $grid->save();

        if($count > 0) {
            $this->createGridCorners($grid);
        }

        # save log in filesystem
        $hash = $grid->id . '_'. sha1(str_random(40));
        $data['request'] = $request;
        $data['response'] = $response;
        Storage::put('paytm/' . $hash.'.json', json_encode($data));

        $gridScanLog = new GridScanLog();
        $gridScanLog->service = $this->serviceName;
        $gridScanLog->store_count = $count;
        $gridScanLog->data_key = $hash;
        $gridScanLog->grid()->associate($grid);
        $gridScanLog->save();
    }

    public function createGridCorners(Grid $grid)
    {
        $lat = round($grid->lat, 2);
        $lng = round($grid->lng, 2);
        // Create grid 8 sides
        $this->createCornerGrid($grid, $lat - 0.1 ,$lng - 0.1);
        $this->createCornerGrid($grid, $lat - 0.1 , $lng);
        $this->createCornerGrid($grid, $lat - 0.1 ,  $lng + 0.1);

        $this->createCornerGrid($grid, $lat , $lng - 0.1);
        $this->createCornerGrid($grid, $lat , $lng);
        $this->createCornerGrid($grid, $lat ,  $lng + 0.1);

        $this->createCornerGrid($grid, $lat + 0.1 , $lng - 0.1);
        $this->createCornerGrid($grid, $lat + 0.1 ,  $lng);
        $this->createCornerGrid($grid, $lat + 0.1 ,  $lng + 0.1);
    }

    private function createCornerGrid(Grid $centerGrid, $lat, $lon)
    {
        $grid = Grid::firstOrCreate(['lat' => round($lat, 1), 'lng' => round($lon,1)]);
        if($grid->processed == 0) {
            $grid->priority =  $centerGrid->store_count;
            $grid->save();
        }
    }

}