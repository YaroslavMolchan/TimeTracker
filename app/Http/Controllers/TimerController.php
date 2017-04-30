<?php

namespace App\Http\Controllers;

use App\Contracts\StatisticRepository;
use App\Entities\Statistic;
use App\Entities\StatisticTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $this->middleware('auth', ['except' => ['index']]);

        $this->statistics = $statistics;
    }

    public function index()
    {
        $timerParams = $this->setTimerParams();

        $action = $timerParams['isWorking'] ? 'stop' : 'play';

        return view('timer.index', compact('action'));
    }

    public function start()
    {
        /** @var Statistic $statistic */
        $statistic = $this->statistics->firstOrCreate([
            'user_id' => request()->user()->id,
            'date' => Carbon::now()->toDateString()
        ]);

        $opened = $this->getOpenedTime($statistic);
        if (!empty($opened)) {
            $this->closeOpenedTime($opened, $statistic);
        }

        $statistic->times()->create([
            'started_at' => Carbon::now()
        ]);

        return [
            'ok' => true,
            'action' => 'resume',
            'view' => view('timer.buttons.stop')->render()
        ];
    }

    public function stop()
    {
        /** @var Statistic $statistic */
        $statistic = request()->user()->dailyStatistic();
        if (is_null($statistic)) {
            throw new NotFoundHttpException('You need to start working first.');
        }

        $opened = $this->getOpenedTime($statistic);

        if (is_null($opened)) {
            throw new NotFoundHttpException('You need to start working first.');
        }

        $this->closeOpenedTime($opened, $statistic);

        return [
            'ok' => true,
            'action' => 'pause',
            'view' => view('timer.buttons.play')->render()
        ];
    }

    /**
     * Setup init timer params for auth user
     * @return array
     */
    protected function setTimerParams()
    {
        $timerParams = [
            'dailyTime' => 0,
            'isWorking' => false
        ];

        $user = \request()->user();
        if (!is_null($user) && !is_null($user->dailyStatistic())) {
            $statistic = $user->dailyStatistic();
            $timerParams['dailyTime'] = $statistic->total;
            /** @var StatisticTime $opened */
            $opened = $this->getOpenedTime($statistic);
            if (!is_null($opened)) {
                $total = $this->getTotalOpenedTime($opened, Carbon::now());
                $timerParams['dailyTime'] += $total;
                $timerParams['isWorking'] = true;
            }
        }
        JavaScript::put($timerParams);

        return $timerParams;
    }

    /**
     * @param $opened
     * @param $statistic
     */
    protected function closeOpenedTime($opened, $statistic)
    {
        $finished_at = Carbon::now();
        $total = $this->getTotalOpenedTime($opened, $finished_at);
        $opened->update([
            'total' => $total,
            'finished_at' => $finished_at
        ]);
        $statistic->increment('total', $total);
    }

    /**
     * @param $statistic
     * @return StatisticTime
     */
    protected function getOpenedTime($statistic)
    {
        /** @var StatisticTime $opened */
        $opened = $statistic->times->where('finished_at', null)->first();
        return $opened;
    }

    /**
     * @param $opened
     * @param $finished_at
     * @return mixed
     */
    protected function getTotalOpenedTime($opened, $finished_at)
    {
        $total = $finished_at->getTimestamp() - $opened->started_at->getTimestamp();
        return $total;
    }
}
