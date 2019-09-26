<?php


namespace App\Scopes;


trait CommonFilterScopes
{

    public function scopeWhereIf($query, $field, $value)
    {
        if ($value) {
            $query->where($field, $value);
        }

        return $query;
    }

    public function scopeWhereLikeIf($query, $field, $value)
    {
        if ($value) {
            $query->where($field, 'like', "%$value%");
        }

        return $query;
    }
}
