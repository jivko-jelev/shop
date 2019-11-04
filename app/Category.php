<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CommonFilterScopes;

    protected $table = 'categories';

    protected $fillable = [
        'id', 'title', 'alias', 'parent_id',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

}
