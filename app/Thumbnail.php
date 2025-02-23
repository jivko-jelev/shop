<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Thumbnail extends Model
{
    protected $table = 'thumbnails';

    protected $fillable = ['filename', 'picture_id', 'size'];

    public $timestamps = true;

    public static $thumbnails = [[100, 100], [200, 200], [300, 300], [600, 600],];

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }

}
