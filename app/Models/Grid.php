<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $fillable = ['lat', 'lng'];

    public function grid()
    {
        $this->hasOne(Grid::class, 'grid_id');
    }
}
