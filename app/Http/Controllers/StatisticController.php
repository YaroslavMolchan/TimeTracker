<?php

namespace App\Http\Controllers;

use App\Contracts\StatisticRepository;
use App\Contracts\UserRepository;
use App\Criteria\CurrentUserDailyCriteria;
use App\Services\UserService;
use Carbon\Carbon;

class StatisticController extends Controller
{
    /**
     * @var StatisticRepository
     */
    private $statistics;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * MainController constructor.
     * @param UserService $userService
     * @param StatisticRepository $statistics
     * @param UserRepository $users
     */
    public function __construct(
        UserService $userService,
        StatisticRepository $statistics,
        UserRepository $users
    )
    {
        $this->middleware('auth', ['except' => ['ajaxDailyTeam']]);

        $this->statistics = $statistics;
        $this->users = $users;
        $this->userService = $userService;
    }

    public function dailyTeam()
    {
        $statistics = $this->userService->getDailyTeamStatistic();

        return view('statistic.daily-team', compact('statistics'));
    }

    public function weeklyTeam()
    {
        $statistics = $this->userService->getWeeklyTeamStatistic();

        return view('statistic.weekly-team', compact('statistics'));
    }

    public function ajaxDailyTeam()
    {
        $statistics = $this->statistics->findByField('date', Carbon::now()->toDateString());

        return [
            'ok' => true,
            'view' => view('statistic.partials.daily-team', compact('statistics'))->render()
        ];
    }

    public function ajaxDailyUser()
    {
        $times = request()->user()->dailyStatistic()->times;

        return [
            'ok' => true,
            'view' => view('statistic.partials.daily-user', compact('times'))->render()
        ];
    }
}
