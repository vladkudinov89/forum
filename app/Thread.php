<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function path()
    {
        return '/threads/' . $this->id;
    }
}
