<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Relationship between a Post and a User. A Post can only belong to a User
    public function user() {
        return $this->belongsTo('App\User');
    }
}
