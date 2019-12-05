<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use CommonFilterScopes;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'description',
        'picture_id',
        'category_id',
        'permalink',
        'price',
        'promo_price',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function picture()
    {
        return $this->hasOne('App\Picture', 'id', 'picture_id');
    }

    public function subProperties()
    {
        return $this->hasMany('App\ProductSubProperties', 'product_id', 'id');
    }

    public function getPicture()
    {
        return URL::to($this->picture ? $this->picture->filename : 'images/empty.jpg');
    }

    public function getThumbnail(int $num = 1)
    {
        return URL::to($this->picture ? $this->picture->thumbnails->where('size', $num)[$num]->filename : "images/empty{$num}.jpg");
    }

    public function priceText()
    {
        return $this->price . ' лв.';
    }

    public function promoPriceText()
    {
        return $this->promo_price . ' лв.';
    }

    public function discountText()
    {
        return '-' . (100 - ($this->promo_price / $this->price) * 100) . '%';
    }

    public static function cyrillicToLatin(string $textcyr): string
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya',
        ];

        return str_replace($cyr, $lat, $textcyr);
    }

    public static function sanitize($string, $force_lowercase = false, $anal = false)
    {
        $strip = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                  "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                  "â€”", "â€“", ",", "<", ".", ">", "/", "?"];
        $clean = trim(str_replace($strip, "-", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}
