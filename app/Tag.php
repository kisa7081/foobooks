<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function books()
    {
        # withTimestamps to have created_at/updated_at auto maintained.
        return $this->belongsToMany('App\Book')-withTimestamps();
    }

    public static function getForCheckboxes()
    {
        return self::orderBy('name')->select(['name', 'id'])->get();
    }
}
