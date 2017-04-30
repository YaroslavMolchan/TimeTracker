<?php

namespace App\Http\Controllers;

use App\Contracts\StatisticRepository;
use App\Criteria\CurrentUserDailyCriteria;
use Carbon\Carbon;

class StatisticController extends Controller
{
    /**
     * @var StatisticRepository
     */
    private $statistics;

    /**
     * MainController constructor.
     * @param StatisticRepository $statistics
     */
    public function __construct(StatisticRepository $statistics)
    {
        $this->middleware('auth', ['except' => ['dailyTeam']]);

        $this->statistics = $statistics;
    }

    public function dailyTeam()
    {
        $statistics = $this->statistics->findByField('date', Carbon::now()->toDateString());

        return [
            'ok' => true,
            'view' => view('statistic.daily-team', compact('statistics'))->render()
        ];
    }

    public function dailyUser()
    {
        $times = request()->user()->dailyStatistic()->times;

        return [
            'ok' => true,
            'view' => view('statistic.daily-user', compact('times'))->render()
        ];
    }
}
