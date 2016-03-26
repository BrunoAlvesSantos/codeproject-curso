<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 15/10/15
 * Time: 19:49
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;


class ProjectTaskTransformer extends TransformerAbstract
{

    public function transform(ProjectTask $projectTask) {
        return [
            'id' => (int)$projectTask->id,
            'project_id' => (int)$projectTask->project_id,
            'name' => $projectTask->name,
            'start_date' => $projectTask->start_date,
            'due_date' => $projectTask->due_date,
            'status' => $projectTask->status,
        ];
    }

}