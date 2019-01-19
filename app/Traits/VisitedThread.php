<?php

namespace App\Traits;


use Illuminate\Support\Facades\Redis;

trait VisitedThread
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function resetVisit()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}