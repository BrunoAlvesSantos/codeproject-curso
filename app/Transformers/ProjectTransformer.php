<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 15/10/15
 * Time: 19:49
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;


class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members'];

    public function transform(Project $project) {
        return [
            'project_id' => (int)$project->id,
            'client_id' => (int)$project->client_id,
            'owner_id' => (int)$project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date
        ];
    }

    public function includeMembers(Project $project) {
        return $this->collection($project->members, new ProjectMemberTransformer());
    }

}