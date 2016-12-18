<?php
namespace EPaymentShops\Repository\Scrappers;
use EPaymentShops\Models\Category;
use EPaymentShops\Models\City;
use EPaymentShops\Models\Shop;
use EPaymentShops\Models\State;

/**
 * Created by PhpStorm.
 * User: jithin
 * Date: 18/12/16
 * Time: 12:33 PM
 */
class PayTm
{

    public function addNewUpdate($data)
    {
        if(!empty($data['cashPointsDetail'])) {
            $data = $data['cashPointsDetail'];

            $shop = Shop::firstOrNew(['paytm_id'=> $data['terminalId']]);
            $shop->name = $data['displayName'];
            $shop->address = implode(', ', $data['address']);
            $shop->contact_no = implode(', ', $data['contactNo']);
            $shop->lat = $data['location']['lat'];
            $shop->lng = $data['location']['lon'];
            $shop->start_time = $data['startTime'].':00';
            $shop->end_time = $data['endTime'].':00';

            $city = $this->newCity($data['city'], $data['state']);
            $shop->city()->associate($city);

            $category = $this->newCategory($data['category'], $data['subCategory']);
            $shop->category()->associate($category);
            $shop->save();
            return $shop;
        }
        return false;
    }

    public  function newCity($cityName, $stateName)
    {
        $state = State::firstOrCreate(['name' => trim($stateName)]);
        return City::firstOrCreate([
            'name' => trim($cityName),
            'state_id' => $state->id
        ]);
    }

    public function newCategory($categoryName, $subCategoryName)
    {
        $category = Category::firstOrCreate(['name' => trim($categoryName)]);
        return Category::firstOrCreate([
            'name' => trim($subCategoryName),
            'parent_category_id' => $category->id
        ]);
    }

}