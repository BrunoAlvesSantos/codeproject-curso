<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    /**
     *
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     *
     * @var ProjectTaskService
     */
    private $service;

    /**
     *
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectService $projectService) {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        if($this->CheckProjectTaskPermissions($id) == false) {
            return [ 'error' => 'Access Forbidden'];
        };
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $taskId)
    {
        if($this->CheckProjectTaskPermissions($id) == false) {
            return [ 'error' => 'Access Forbidden'];
        };
        return $this->service->find($id, $taskId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $taskId)
    {
        $projectTask = $this->repository->skipPresenter()->find($id);
        $projectId = $projectTask->project_id;

        if($this->CheckProjectTaskPermissions($projectId) == false) {
            return [ 'error' => 'Access Forbidden'];
        };

        $this->service->update($request->all(), $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $taskId)
    {
        $projectTask = $this->repository->skipPresenter()->find($id);
        $projectId = $projectTask->project_id;

        if($this->CheckProjectTaskPermissions($projectId) == false) {
            return [ 'error' => 'Access Forbidden'];
        };

        $this->service->delete($taskId);
    }

    private function CheckProjectTaskPermissions($projectId) {
        if($this->projectService->checkProjectOwner($projectId) or $this->projectService->checkProjectMember($projectId)) {
            return true;
        }

        return false;

    }
}
