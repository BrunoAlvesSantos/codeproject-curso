<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 31/07/15
 * Time: 23:41
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{

    protected $rules = [
        'name' => 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'addres' => 'required',
    ];
}