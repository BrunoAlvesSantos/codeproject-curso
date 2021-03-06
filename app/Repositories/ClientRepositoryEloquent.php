<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 22/07/15
 * Time: 21:20
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use CodeProject\Presenters\ClientPresenter;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    protected $fieldSearchable = [
        'name'=>'like',
    ];

    public function model()
    {
        return Client::class;
    }

    public function presenter() {
        return ClientPresenter::class;
    }

    public function boot() {
        $this->pushCriteria(app(RequestCriteria::class));
        //$this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
}