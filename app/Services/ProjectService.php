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
use CodeProject\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

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

    /**
     * @var FileSystem
     */
    protected $filesystem;

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var ProjectFileValidator
     */
    protected $validatorProjectFile;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, FileSystem $filesystem, Storage $storage, ProjectFileValidator $validatorProjectFile)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        $this->validorProjectFile = $validatorProjectFile;
    }

    public function all() {
        try
        {
            return $this->repository->with(['owner', 'client', 'members'])->all();
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
            return $this->repository->with(['owner', 'client', 'members'])->find($id);
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

            if(!empty($result->id) && !empty($data['user_id']))
                $this->addMember(['project_id' => $result->id, 'user_id' => $data['user_id']]);

            return $result;

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
            $members =  $this->repository->skipPresenter()->find($id)->members;

            if(count($members))
                return $members;

            return [
                'error' => true,
                'message' => 'No members in this project',
            ];
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

    public function createFile(array $data){
        try {
            $this->validorProjectFile->with($data)->passesOrFail();

            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function deleteFile($projectId) {

        $files = $this->repository->skipPresenter()->find($projectId)->files;

        $delete = [];
        foreach ($files as $file) {
            $path = $file->id.'.'.$file->extension;

            if($file->delete($file->id))
                $delete[] = $path;
        }

        $return = $this->storage->delete($delete);

        if($return)
            return ['error' => false];
        else
            return ['error' => true];

    }

    public function CheckProjectOwner($projectId) {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId,$userId);
    }

    public function CheckProjectMember($projectId) {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId,$userId);
    }

    public function CheckProjectPermissions($projectId) {
        if($this->CheckProjectOwner($projectId) or $this->CheckProjectMember($projectId))
            return true;
        return false;
    }
}