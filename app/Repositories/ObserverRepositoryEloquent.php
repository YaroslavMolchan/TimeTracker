<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\ObserverRepository;
use App\Entities\Observer;
use App\Validators\ObserverValidator;

/**
 * Class ObserverRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ObserverRepositoryEloquent extends BaseRepository implements ObserverRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Observer::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
