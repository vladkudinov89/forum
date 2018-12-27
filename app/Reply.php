<?php

namespace App;

use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $table = 'replies';

    protected $fillable = [
        'thread_id', 'user_id', 'body'
    ];

    protected $guarded = [];

    protected $with = ['owner' , 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
