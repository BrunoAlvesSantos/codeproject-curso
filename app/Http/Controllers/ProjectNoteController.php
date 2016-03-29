<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;

use CodeProject\Services\ProjectService;

class ProjectNoteController extends Controller
{

    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectService $projectService)
    {

        $this->repository = $repository;
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {
        return $this->repository->findWhere(['project_id' => $projectId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //dd($request->all());
        //return $this->service->create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $idNote)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $idNote]);
        if(isset($result['data']) && count($result['data']) == 1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $idNote)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->update($data, $idNote);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $noteId)
    {

        $this->repository->delete($noteId);

    }



    private function checkProjectNotePermissions($projectId){

        if($this->projectService->checkProjectOwner($projectId) or $this->projectService->checkProjectMember($projectId)){
            return true;
        }
        return false;

    }
}
