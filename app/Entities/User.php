<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'google_user_id',
        'avatar'
    ];

    public function dailyStatistic()
    {
        return $this->statistics->where('date', Carbon::now()->toDateString())->first();
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }
}
