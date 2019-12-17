<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductPictures extends Model
{
    protected $table = 'product_pictures';

    protected $fillable = [
        'product_id',
        'picture_id',
    ];

    public $timestamps = false;

    public function thumbnails()
    {
        return $this->hasMany('App\Thumbnail', 'picture_id', 'picture_id');
    }

}
