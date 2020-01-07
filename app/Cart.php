<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $table      = 'carts';
    public $timestamps = false;
    public $fillable   = [
        '',
    ];

    public static function total($cart)
    {
        $total = 0;
        foreach ($cart as $c) {
            $total += $c->quantity * $c->price;
        }
        return Functions::priceText($total);
    }
}
