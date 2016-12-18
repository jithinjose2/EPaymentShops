<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'parent_category_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function child()
    {
        return $this->hasOne(Category::class);
    }
}
