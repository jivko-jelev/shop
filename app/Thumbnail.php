<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    protected $table = 'thumbnails';

    protected $fillable = ['filename', 'picture_id', 'size'];

    public $timestamps = false;

    public static $thumbnails = [[100, 100], [300, 300], [600, 600],];

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }

}
