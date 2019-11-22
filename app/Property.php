<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = ['name', 'category_id'];

    public $timestamps = false;

    public function subProperties()
    {
        return $this->hasMany(SubProperty::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
