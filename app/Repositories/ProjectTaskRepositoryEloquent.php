<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 22/07/15
 * Time: 21:20
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\ProjectTask;
use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Presenters\ProjectTaskPresenter;

class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{

    public function model()
    {
        return ProjectTask::class;
    }

    public function presenter() {
        return ProjectTaskPresenter::class;
    }
}