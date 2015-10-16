<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 01/08/15
 * Time: 00:53
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{

    protected $rules = [
        'file' => 'required|max:2000',
        'project_id' => 'required|integer',
        'name' => 'required|max:255',
        'extension' => 'required|max:255',
    ];
}