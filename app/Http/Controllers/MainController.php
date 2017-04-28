<?php

namespace App\Http\Controllers;

use App\Contracts\StatisticRepository;
use App\Criteria\CurrentUserDailyCriteria;
use Carbon\Carbon;

class MainController extends Controller
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

    public function index()
    {
        return view('main.index');
    }

    public function start()
    {
        $user = request()->user;
        $statistic = $this->statistics->findWhere([
            'user_id' => $user->id,
            'date' => Carbon::now()
        ]);
        dd($statistic);
        if (is_null($statistic)) {
            $statistic = $this->statistics->create([
                'user_id' => $user->id,
                'date' => Carbon::now()
            ]);
        }
    }
}
