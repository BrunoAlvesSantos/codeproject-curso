<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 15/10/15
 * Time: 19:49
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;


class ProjectNoteTransformer extends TransformerAbstract
{

    public function transform(ProjectNote $projectNote) {
        return [
            'id' => (int)$projectNote->id,
            'project_id' => (int)$projectNote->project_id,
            'title' => $projectNote->title,
            'note' => $projectNote->note,
        ];
    }

}