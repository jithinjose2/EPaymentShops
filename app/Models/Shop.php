<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $fillable = ['paytm_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
