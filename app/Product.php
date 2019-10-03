<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CommonFilterScopes;

    protected $table = 'products';

    protected $fillable = [
        'id', 'name', 'description', 'picture', 'category_id', 'permalink'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
