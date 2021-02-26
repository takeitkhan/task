<?php

namespace Tritiyo\Task\Controllers;

use Tritiyo\Task\Models\TaskStatus;
use Tritiyo\Task\Repositories\TaskStatus\TaskStatusInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TaskStatusController extends Controller
{
    /**
     * @var TaskSiteInterface
     */
    private $taskstatus;

    /**
     * RoutelistController constructor.
     * @param TaskStatusInterface $taskstatus
     */
    public function __construct(TaskStatusInterface $taskstatus)
    {
        $this->taskstatus = $taskstatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskstatuss = $this->tasksite->getAll();
        return view('task::index', ['tasksites' => $taskstatuss]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task::taskstatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),
            [
                'task_id' => 'required',
                'vehicle_id' => 'required',
                'vehicle_rent' => 'required',
            ]
        );
        // process the login
        if ($validator->fails()) {
            return redirect('tasks.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
        
            foreach($request->vehicle_id as $key => $row) {
                $attributes = [
                    'task_id'  => $request->task_id,
                    'vehicle_id' => $request->vehicle_id[$key],
                    'vehicle_rent' => $request->vehicle_rent[$key],
                ];          
                $taskstatus = $this->taskstatus->create($attributes);               
            }
            
            try {
              //  $taskstatus = $this->tasksite->create($arr);
                //return view('task::create', ['task' => $taskstatus]);
                return redirect(route('tasks.index'))->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return view('task::create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskstatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskSite $taskstatus)
    {
        return view('task::show', ['task' => $taskstatus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskSite $taskstatus)
    {
        return view('task::taskstatus.create', ['task' => $taskstatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Tritiyo\Task\Models\Task $taskstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());

        $t = TaskStatus::where('task_id', $request->task_id);
        $t->delete();
        foreach($request->vehicle_id as $key => $row) {
            $attributes = [
                'task_id'  => $request->task_id,
                'vehicle_id' => $request->vehicle_id[$key],
                'vehicle_rent' => $request->vehicle_rent[$key],
            ];          
            $taskstatus = $this->taskstatus->create($attributes);               
        }
       //dd($request->all());
        try {
            //$taskstatus = $this->task->update($taskstatus->id, $attributes);
           
           return back()->with('message', 'Successfully saved')->with('status', 1);
                // ->with('task', $taskstatus);
        } catch (\Exception $e) {
            return view('task::edit', $taskstatus->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Tritiyo\Task\Models\Task $taskstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->task->delete($id);
        return redirect()->back()->with(['status' => 1, 'message' => 'Successfully deleted']);
    }

}
