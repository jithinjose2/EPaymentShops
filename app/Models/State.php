<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    protected $fillable = ['name'];

    protected $hidden = array('created_at', 'updated_at');

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id');
    }
}
