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

    public function getShops(Request $request)
    {
        $this->validate($request, [
            'from_lat'  => 'required|double',
            'from_lng'  => 'required|double',
            'to_lat'    => 'required|double',
            'to_lng'    => 'required|double'
        ]);

        $from = ['lat' => $request->get('from_lat'), 'lng' => $request->get('from_lng')];
        $to = ['lat' => $request->get('to_lat'), 'lng' => $request->get('to_lng')];
        $filter = [];
        if($request->has('category_id')) {
            $filter['category_id'] = $request->get('category_id');
        }
        $shops = $this->shopQuery->getNearestShops($from, $to, $filter);
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
