<?php

namespace EPaymentShops\Http\Controllers;

use EPaymentShops\Models\Category;
use EPaymentShops\Models\City;
use EPaymentShops\Models\State;
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

    public function categories()
    {
        $categories = Category::select(['id', 'name'])
            ->with('children')
            ->whereNull('parent_category_id')->get();
        return $categories;
    }

    public function states()
    {
        return State::select(['id','name'])->get();
    }

    public function cities()
    {
        return City::select(['id','name', 'state_id'])->with('state')->get();
    }

}
