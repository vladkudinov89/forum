<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';

    protected $fillable = [
        'thread_id', 'user_id', 'body'
    ];

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo('App\User' , 'user_id');
    }
}
