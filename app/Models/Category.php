<?php

namespace EPaymentShops\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'parent_category_id'];

    protected $hidden = array('created_at', 'updated_at');

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }
}
