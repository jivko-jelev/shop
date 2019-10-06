<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Picture extends Model
{
    protected $table = 'pictures';

    protected $fillable = ['filename'];

    const MAX_WIDTH  = 800;
    const MAX_HEIGHT = 1200;

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }

    public static function cropImage($filename)
    {
        $image = Image::make($filename);
        if ($image->width() / Picture::MAX_WIDTH < $image->height() / Picture::MAX_HEIGHT) {
            $image->widen(Picture::MAX_WIDTH)
                  ->crop(Picture::MAX_WIDTH, Picture::MAX_HEIGHT, 0, 0)
                  ->save();
        } else {
            $image->heighten(Picture::MAX_HEIGHT)
                  ->crop(Picture::MAX_WIDTH, Picture::MAX_HEIGHT, round($image->width() / 2 - Picture::MAX_WIDTH / 2), 0)
                  ->save();
        }
    }

    public static function generateUniqueFilename(string $fname): string
    {
        $path     = substr($fname, 0, strrpos($fname, '/') + 1);
        $filename = substr($fname, strrpos($fname, '/') + 1);
        $filename = Product::sanitize(substr($filename, 0, strrpos($filename, '.')));
        $ext      = substr($fname, strrpos($fname, '.') + 1);

        $permalinks = Picture::select('filename')->where('filename', 'like', $path . $filename . '%')->get();
        if ($permalinks->where('filename', '=', "$path$filename.$ext")->count() == 0) {
            return "$filename.$ext";
        } else {
            $counter = 0;
            while ($permalinks->where('filename', '=', "$path$filename-" . ++$counter . ".$ext")->count() > 0) {
            }

            return $filename . '-' . $counter . '.' . $ext;
        }
    }

    public function generateThumbnails()
    {
        $path     = substr($this->filename, 0, strrpos($this->filename, '/') + 1) . 'thumbnails/';
        $filename = substr($this->filename, strrpos($this->filename, '/') + 1);
        $filename = substr($filename, 0, strrpos($filename, '.'));
        $ext      = substr($this->filename, strrpos($this->filename, '.') + 1);

        $pathToThumbnails = substr($path, strpos($path, '/') + 1);
        Storage::makeDirectory($pathToThumbnails);

        foreach (Thumbnail::$thumbnails as $key => $thumbnail) {
            $thumbnailFilename = "$path$filename-$thumbnail[0]x$thumbnail[1].$ext";

            Thumbnail::create([
                'filename'   => $thumbnailFilename,
                'picture_id' => $this->id,
                'size'       => $key,
            ]);

            $image = Image::make($this->filename)
                          ->widen($thumbnail[0])
                          ->crop($thumbnail[0], $thumbnail[1], 0, 0)
                          ->save($thumbnailFilename);
        }
    }
}
