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

    public static function cropImage($source, $dest, $width, $height)
    {
        $image    = Image::make($source);
        $newImage = Image::canvas($width, $height);
        if ($image->width() / $width > $image->height() / $height) {
            $image->widen($width);
            $newImage->insert($image, 'top', 0, round($height / 2 - $image->height() / 2));
        } else {
            $image->heighten($height);
            $newImage->insert($image, 'top', round($width / 2 - $image->width() / 2), 0);
        }
        $newImage->save($dest);
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

    public function generateThumbnails($source)
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

            Picture::cropImage($source, $thumbnailFilename, $thumbnail[0], $thumbnail[1]);
        }
    }
}
