<?php

namespace Tritiyo\Task\Controllers;

use Tritiyo\Task\Models\TaskSite;
use Tritiyo\Task\Repositories\TaskSiteInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TaskSiteController extends Controller
{
    /**
     * @var TaskSiteInterface
     */
    private $tasksite;

    /**
     * RoutelistController constructor.
     * @param TaskSiteInterface $tasksite
     */
    public function __construct(TaskSiteInterface $tasksite)
    {
        $this->tasksite = $tasksite;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasksites = $this->tasksite->getAll();
        return view('task::index', ['tasksites' => $tasksites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task::tasksite.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),
            [
                'task_id' => 'required',
                'site_id' => 'required',
                'resource_id' => 'required',
            ]
        );
        // process the login
        if ($validator->fails()) {
            return redirect('tasks.create')
                ->withErrors($validator)
                ->withInput();
        } else {

            
            // store
            $attributes = [
                'task_id'  => $request->task_id,
                'site_id' => $request->site_id,
                'resource_id' => $request->resource_id,
            ];

            //dd($request->resource_id);
        
            $arr = array();

            foreach($request->site_id as $key => $row) {
                foreach($request->resource_id as $k => $r) {
                    $arr['task_id'] = $request->task_id;
                    $arr['site_id'] = $row;
                    $arr['resource_id'] = $r; 
                    $arr['created_at'] = now();   
                    $arr['updated_at'] = now();   
                    $tasksite = $this->tasksite->create($arr);                 
                }                
            }
            
            try {
              //  $tasksite = $this->tasksite->create($arr);
                //return view('task::create', ['task' => $tasksite]);
                return redirect(route('tasks.index'))->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return view('task::create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $tasksite
     * @return \Illuminate\Http\Response
     */
    public function show(TaskSite $tasksite)
    {
        return view('task::show', ['task' => $tasksite]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $tasksite
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskSite $tasksite)
    {
        return view('task::edit', ['task' => $tasksite]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Tritiyo\Task\Models\Task $tasksite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());
        // store
        // $attributes = [
        //     'project_id' => $request->project_id,
        //     'location' => $request->location,
        //     'site_code' => $request->site_code,
        //     'budget' => $request->budget,
        // ];

        $arr = array();
        $t = TaskSite::where('task_id', $request->task_id);
        $t->delete();
        foreach($request->site_id as $key => $row) {
            foreach($request->resource_id as $k => $r) {
                    $arr['task_id'] = $request->task_id;
                    $arr['site_id'] = $row;
                    $arr['resource_id'] = $r;
                    $arr['created_at'] = now(); 
                    $arr['updated_at'] = now(); 
                    $t->insert($arr);
            }   
        }
       //dd($request->all());
        try {
            //$tasksite = $this->task->update($tasksite->id, $attributes);
           
           return back()->with('message', 'Successfully saved')->with('status', 1);
                // ->with('task', $tasksite);
        } catch (\Exception $e) {
            return view('task::edit', $tasksite->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Tritiyo\Task\Models\Task $tasksite
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->task->delete($id);
        return redirect()->back()->with(['status' => 1, 'message' => 'Successfully deleted']);
    }

    public function taskSitebyTaskId($id){
        $taskSites = TaskSite::where('task_id', $id)->get();
        $taskId = $id;
        return view('task::tasksite.create', compact('taskSites', 'taskId'));
        // }
    }

}
