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

    public function getThumbnail(int $num = 1)
    {
        return URL::to($this->picture ? $this->picture->thumbnails->where('size', $num)[$num]->filename : "images/empty{$num}.jpg");
    }
}
