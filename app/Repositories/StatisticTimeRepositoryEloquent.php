<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\StatisticTimeRepository;
use App\Entities\StatisticTime;
use App\Validators\StatisticTimeValidator;

/**
 * Class StatisticTimeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class StatisticTimeRepositoryEloquent extends BaseRepository implements StatisticTimeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StatisticTime::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
