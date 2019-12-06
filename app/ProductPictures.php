<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPictures extends Model
{
    protected $table = 'product_pictures';

    protected $fillable = [
        'product_id',
        'picture_id',
    ];

}
