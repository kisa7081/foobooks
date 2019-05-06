<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function author()
    {
        # Book belongs to Author
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Author');
    }

    public function tags()
    {
        # withTimestamps to have created_at/updated_at auto maintained.
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
