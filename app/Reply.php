<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable , RecordActivity;

    protected $table = 'replies';

    protected $fillable = [
        'thread_id', 'user_id', 'body'
    ];

    protected $guarded = [];

    protected $appends = ['favoritesCount' , 'isFavorited'];

    protected $with = ['owner' , 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

}
