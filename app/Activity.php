<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
//    protected $fillable = [
//      'user_id'
//    ];
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }
}
