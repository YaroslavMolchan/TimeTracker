<?php

namespace App\Console\Commands;

use App\Contracts\StatisticTimeRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DailyCheckerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var StatisticTimeRepository
     */
    private $times;

    /**
     * Create a new command instance.
     * @param StatisticTimeRepository $times
     */
    public function __construct(StatisticTimeRepository $times)
    {
        $this->times = $times;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $opened = $this->times->findByField('finished_at', Carbon::now()->toDateString());
        foreach ($opened as $time) {
            if ($opened->started_at->format('G') < 18) {
                $finished_at = Carbon::create(date('Y'), date('m'), date('d'), 18);
            }
            else {
                $finished_at = Carbon::now();
            }
            $total = $finished_at->getTimestamp() - $opened->started_at->getTimestamp();
            $opened->update([
                'total' => $total,
                'finished_at' => $finished_at
            ]);
            $time->statistic->increment('total', $total);
        }
    }
}
