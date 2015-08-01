<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 01/08/15
 * Time: 00:53
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required|max:255',
        /*'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'addres' => 'required', */
    ];
}