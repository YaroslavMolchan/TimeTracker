<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StatisticTime extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'started_at',
        'finished_at',
        'created_at',
        'updated_at'
    ];

    public function statistic()
    {
        return $this->belongsTo(Statistic::class);
    }
}
