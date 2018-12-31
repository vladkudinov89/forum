<?php

namespace App\Traits;


use App\Activity;
use App\Thread;

trait RecordActivity
{

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivityRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        };

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivityRecord()
    {
        return ['created'];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }

    protected function getActivityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

}