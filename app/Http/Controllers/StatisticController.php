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
        $this->statistics = $statistics;
    }

    public function dailyTeam()
    {
        return view('statistic.daily-team');
    }

    public function dailyUser()
    {
        return view('statistic.daily-user');
    }
}
