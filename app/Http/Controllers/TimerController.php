<?php

namespace App\Http\Controllers;

use App\Contracts\StatisticRepository;
use App\Entities\Statistic;
use App\Entities\StatisticTime;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JavaScript;

class TimerController extends Controller
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
        $timerParams = [
            'dailyTime' => 0,
            'isWorking' => false
        ];

        $user = request()->user();
        if (!is_null($user)) {
            /** @var Statistic $statistic */
            $statistic = $this->statistics->findWhere([
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString()
            ])->first();
            if (!is_null($statistic)) {
                $timerParams['dailyTime'] =  $statistic->total;
                /** @var StatisticTime $opened */
                $opened = $statistic->times->where('finished_at', null)->first();
                if (!is_null($opened)) {
                    $finished_at = Carbon::now();
                    $total = $finished_at->getTimestamp() - $opened->started_at->getTimestamp();
                    $timerParams['dailyTime'] +=  $total;
                    $timerParams['isWorking'] = true;
                }
            }
        }

        $action = $timerParams['isWorking'] ? 'stop' : 'play';

        JavaScript::put($timerParams);
        return view('timer.index', compact('action'));
    }

    public function start()
    {
        $user = request()->user();
        $statistic = $this->statistics->findWhere([
            'user_id' => $user->id,
            'date' => Carbon::now()->toDateString()
        ])->first();
        if (is_null($statistic)) {
            $statistic = $this->statistics->create([
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString()
            ]);
        }

        $opened = $statistic->times->where('finished_at', null)->first();
        if (!empty($opened)) {
            $finished_at = Carbon::now();
            $total = $finished_at->getTimestamp() - $opened->started_at->getTimestamp();
            $opened->update([
                'total' => $total,
                'finished_at' => $finished_at
            ]);
            $statistic->increment('total', $total);
        }

        $statistic->times()->create([
            'started_at' => Carbon::now()
        ]);

        return [
            'ok' => true,
            'view' => view('timer.buttons.stop')->render()
        ];
    }

    public function stop()
    {
        $user = request()->user();
        /** @var Statistic $statistic */
        $statistic = $this->statistics->findWhere([
            'user_id' => $user->id,
            'date' => Carbon::now()->toDateString()
        ])->first();
        if (is_null($statistic)) {
            throw new NotFoundHttpException('You need to start working first.');
        }

        /** @var StatisticTime $opened */
        $opened = $statistic->times->where('finished_at', null)->first();
        if (empty($opened)) {
            throw new NotFoundHttpException('You need to start working first.');
        }

        $finished_at = Carbon::now();
        $total = $finished_at->getTimestamp() - $opened->started_at->getTimestamp();
        $opened->update([
            'total' => $total,
            'finished_at' => $finished_at
        ]);
        $statistic->increment('total', $total);

        return [
            'ok' => true,
            'view' => view('timer.buttons.play')->render()
        ];
    }
}
