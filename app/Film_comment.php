<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film_comment extends Model
{
    protected $table = 'film_comments';

    protected $fillable = [
        'name','description','film_id','user_id'
    ];
}
