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

    public function getNearestShops($from, $to, $filter)
    {
        $shops = Shop::where('lat', '>', $from['lat'])->where('lat', '<', $to['lat'])
            ->where('lng', '>', $from['lng'])->where('lng', '<', $from['to'])
            ->limit(100);

        return $shops->get();
    }

}