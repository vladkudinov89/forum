<?php

namespace App;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;

    protected $table = 'threads';

    protected $guarded = [];

    protected $fillable = [
        'user_id', 'channel_id', 'title', 'body'
    ];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('replyCount', function ($builder) {
//            $builder->withCount('replies');
//        });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug }/{$this->id}";
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function subscribe($userId = null)
    {
       $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
       ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
        ->where('user_id' , $userId ?: auth()->id() )
        ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscribe::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id' , auth()->id())
            ->exists();
    }

    public static function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
