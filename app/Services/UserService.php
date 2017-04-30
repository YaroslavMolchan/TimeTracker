<?php

namespace App\Services;

use App\Contracts\UserRepository;
use App\Entities\Statistic;
use App\Entities\StatisticTime;
use App\Entities\User;
use Carbon\Carbon;

class UserService {
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UserService constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Return array of all team users with their daily statistic
     * @param null $date
     * @return array
     */
    public function getDailyTeamStatistic($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now();
        }
        $result = [];
        /** @var User[] $users */
        $users = $this->users->all();
        foreach ($users as $user) {
            /** @var Statistic $statistic */
            $statistic = $user->dailyStatistic($date);
            if (!is_null($statistic)) {
                /** @var StatisticTime $lastTime */
                $lastTime = $statistic->times->last();
                $started_at = $statistic->created_at->toTimeString();
                $finished_at = (!is_null($lastTime) && !is_null($lastTime->finished_at)) ? $lastTime->finished_at->toTimeString() : '-';
                $total = $statistic->getTotalTime();
                $is_active = !$statistic->isFinished();
                $data = [
                    'name' => $user->name,
                    'created_at' => $started_at,
                    'finished_at' => $finished_at,
                    'total' => [
                        'seconds' => $total,
                        'is_active' => (int)$is_active
                    ]
                ];
            }
            else {
                $data = [
                    'name' => $user->name
                ];
            }

            array_push($result, $data);
        }

        return $result;
    }

    public function getWeeklyTeamStatistic()
    {
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->endOfWeek();
        $result = [];
        for($date = clone $monday; $date < $sunday; $date->addDay()) {
            $result[$date->toDateString()] = $this->getDailyTeamStatistic($date);
        }

        return $result;
    }
}