<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class GridScanLog extends Model
{
    protected $fillable = ['grid_id'];

    public function grid()
    {
        return $this->belongsTo(Grid::class, 'grid_id');
    }
}
