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

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    public function model()
    {
        return Client::class;
    }
}