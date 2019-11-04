<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = ['name', 'product_id'];

    public function subProperties()
    {
        return $this->hasMany(SubProperty::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
