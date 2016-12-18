<?php

namespace EPaymentShops\Http\Controllers;

use EPaymentShops\Repository\ShopQuery;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function __construct(ShopQuery $shopQuery)
    {
        $this->shopQuery = $shopQuery;
    }

    public function getShops()
    {
        $shops = $this->shopQuery->getNearestShops(12.928945299999999, 77.610288, 0.05, []);
        return $shops->toArray();
    }

}
