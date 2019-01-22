<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use App\Traits\RecordActivity;
use App\Traits\VisitedThread;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;

    protected $table = 'threads';

    protected $guarded = [];

    protected $fillable = [
        'user_id', 'channel_id', 'title', 'body' , 'visits' , 'slug' , 'best_reply_id' , 'locked'
    ];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
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
        return "/threads/{$this->channel->slug }/{$this->slug}";
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    public function lock()
    {
        $this->update([
           'locked' => true
        ]);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscribe::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return $this->visits;
    }

    public static function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        while (static::whereSlug($slug)->exists()){
            $slug = "{$slug}-" . $this->id;
        }
        
        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->best_reply_id = $reply->id;

        $this->save();
    }
}
