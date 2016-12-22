<?php
/**
 * Created by PhpStorm.
 * User: jithin
 * Date: 18/12/16
 * Time: 6:31 PM
 */

namespace EPaymentShops\Repository;


use EPaymentShops\Models\Shop;

class ShopQuery
{

    public function getNearestShops($lat, $lng, $distance, $filter)
    {
        $shops = Shop::where('lat', '>', $lat-$distance)->where('lat', '<', $lat+$distance)
            ->where('lng', '>', $lng-$distance)->where('lng', '<', $lng+$distance)
            ->limit(100);

        return $shops->get();
    }

}