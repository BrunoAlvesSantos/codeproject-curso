<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 15/10/15
 * Time: 19:58
 */

namespace CodeProject\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use CodeProject\Transformers\ProjectTransformer;

class ProjectPresenter extends FractalPresenter
{
    public function getTransformer() {
        return new ProjectTransformer();
    }

}