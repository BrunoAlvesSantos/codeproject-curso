<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 01/08/15
 * Time: 00:52
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
{

    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function find($id, $noteId) {

        $note = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);

        if($note->count())
            return $note;

        return [
            'error' => true,
            'message' => 'Task not found'
        ];

    }

    public function create(array $data)
    {

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->create($data);

        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

    }

    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data,$id);

        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }


    }

    public function delete($id) {
        if($this->repository->delete($id))
            return [
                'error' => false,
                'message' => 'Task removed'
            ];
        return [
            'error' => true,
            'message' => 'Could not remove the task'
        ];
    }
}