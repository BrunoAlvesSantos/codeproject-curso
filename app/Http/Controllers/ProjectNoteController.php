<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectNoteController extends Controller
{
    /**
     *
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     *
     * @var ProjectNoteService
     */
    private $service;

    /**
     *
     * @var ProjectService
     */
    private $projectService;


    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectService $projectService) {
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
        if($this->CheckProjectNotePermissions($id) == false) {
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
    public function show($id, $noteId)
    {
        if($this->CheckProjectNotePermissions($id) == false) {
            return [ 'error' => 'Access Forbidden'];
        };
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        if(isset($result['data']) && count($result['data']) == 1) {
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $projectNote = $this->repository->skipPresenter()->find($id);
        $projectId = $projectNote->project_id;

        if($this->CheckProjectNotePermissions($projectId) == false) {
            return [ 'error' => 'Access Forbidden'];
        };

        $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
    }

    private function CheckProjectNotePermissions($projectId) {
        if($this->projectService->checkProjectOwner($projectId) or $this->projectService->checkProjectMember($projectId)) {
            return true;
        }

        return false;

    }
}
