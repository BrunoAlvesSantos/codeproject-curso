<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 22/07/15
 * Time: 21:20
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\ProjectNote;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectNoteRepositoryEloquent extends BaseRepository implements ProjectNoteRepository
{

    public function model()
    {
        return ProjectNote::class;
    }
}