<?php


namespace App;


use Illuminate\Support\Facades\DB;

class Functions
{
    public static function getEnumValues($table, $field): array
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'"))[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);

        return $enum;
    }
}