<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CommonFilterScopes;

    protected $table = 'categories';

    protected $fillable = [
        'id', 'title', 'alias', 'parent_id',
    ];
}
