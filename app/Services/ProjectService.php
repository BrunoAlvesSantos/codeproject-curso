<?php
/**
 * Created by PhpStorm.
 * User: brunoasantos
 * Date: 01/08/15
 * Time: 00:52
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all() {
        try
        {
            return $this->repository->with(['owner', 'client'])->all();
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function find($id) {
        try
        {
            return $this->repository->with(['owner', 'client'])->find($id);
        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
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

    public function delete($id)
    {
        try
        {
            //  $this->repository->find($id)->projects()->delete();
            $this->repository->delete($id);

            return ['success' => true];

        }
        catch (\Exception $e)
        {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }


    }

    public function members($id) {
        try {
            return $this->repository->find($id)->members();
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function addMember($id, $userId) {
        try {
            $this->repository->find($id)->members()->attach($userId);
            return ['success' => true];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function removeMember($id, $userId) {
        try {
            $this->repository->find($id)->members()->detach($userId);
            return ['success' => true];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function isMember($id, $userId) {
        try {
            return $this->repositoy->find($id)->members()->find($userId) ? ['success' => true, 'isMember' => true] : ['success' => false, 'isMember' => false];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}