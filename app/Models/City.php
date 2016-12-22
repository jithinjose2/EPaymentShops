<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = ['name', 'state_id'];

    protected $hidden = array('created_at', 'updated_at');

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
