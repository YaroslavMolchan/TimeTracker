<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $guarded = ['id'];

    public function openedTime()
    {
        return $this->times->last(function ($time) {
            return is_null($time->finished_at);
        });
    }

    public function isFinished()
    {
        return is_null($this->openedTime());
    }

    public function getTotalTime()
    {
        $total = $this->total;
        if (!$this->isFinished()) {
            $total += Carbon::now()->getTimestamp() - $this->openedTime()->started_at->getTimestamp();
        }
        return $total;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function times()
    {
        return $this->hasMany(StatisticTime::class);
    }
}
