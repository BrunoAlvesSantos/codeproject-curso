<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 15/10/15
 * Time: 19:49
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;


class ProjectMemberTransformer extends TransformerAbstract
{

    public function transform(User $member) {
        return [
            'member_id' => $member->id,
            'member' => $member->name,
        ];
    }
}