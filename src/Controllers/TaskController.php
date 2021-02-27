<?php

namespace Tritiyo\Task\Controllers;

use Tritiyo\Task\Helpers\TaskHelper;
use Tritiyo\Task\Models\Task;
use Tritiyo\Task\Models\TaskSite;
use Tritiyo\Task\Models\TaskVehicle;
use Tritiyo\Task\Models\TaskMaterial;
use Tritiyo\Task\Repositories\TaskInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * RoutelistController constructor.
     * @param TaskInterface $task
     */
    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->task->getAll();
        return view('task::index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task::create');
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
                'project_id' => 'required',
                'task_name' => 'required',
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
                'user_id' => auth()->user()->id,
                'task_type' => $request->task_type,
                'project_id' => $request->project_id,
                'task_code' => $request->task_code ?? null,
                'task_name' => $request->task_name,
                'site_head' => $request->site_head,
                'task_details' => $request->task_details,
            ];

            try {
                $task = $this->task->create($attributes);
                return view('task::create', ['task' => $task]);
                //return redirect(route('tasks.index'))->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return view('task::create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task::show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (auth()->user()->isApprover(auth()->user()->id)) {
            $chunck = array(
                'task' => $task,
                'task_site' => \Tritiyo\Task\Models\TaskSite::where('task_id', $task->id)->get()->toArray(),
                'task_vehicle' => \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task->id)->get()->toArray(),
                'task_material' => \Tritiyo\Task\Models\TaskMaterial::where('task_id', $task->id)->get()->toArray(),
                'task_proof' => \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->get()->toArray(),
                'task_status' => \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->get()->toArray(),
            );

            //$chunck_update = \Tritiyo\Task\Models\TaskChunck::update();
            $chunck = \Tritiyo\Task\Models\TaskChunck::updateOrCreate(
                array('task_id' => $task->id),
                array('manager_data' => json_encode($chunck))
            );
        }
        return view('task::edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Tritiyo\Task\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {

        if (auth()->user()->isManager(auth()->user()->id) && $request->task_assigned_to_head) {

            $atts = Task::find($task->id);
            $atts->task_assigned_to_head = $request->task_assigned_to_head;
            $atts->save();


            TaskHelper::statusUpdate([
                'code' => TaskHelper::getStatusKey('task_assigned_to_head'),
                'task_id' => $request->task_id,
                'action_performed_by' => auth()->user()->id,
                'performed_for' => null,
                'requisition_id' => null,
                'message' => TaskHelper::getStatusMessage('task_assigned_to_head')
            ]);

            return redirect()->back();
        }

        if (auth()->user()->isApprover(auth()->user()->id)) {
            TaskHelper::statusUpdateOrInsert([
                'code' => TaskHelper::getStatusKey('task_approver_edited'),
                'task_id' => $request->task->id,
                'action_performed_by' => auth()->user()->id,
                'performed_for' => null,
                'requisition_id' => null,
                'message' => TaskHelper::getStatusMessage('task_approver_edited')
            ]);
        }


        // store
        $attributes = [
            'task_type' => $request->task_type,
            'project_id' => $request->project_id,
            'task_code' => $request->task_code ?? null,
            'task_name' => $request->task_name,
            'site_head' => $request->site_head,
            'task_details' => $request->task_details,
            'task_assigned_to_head' => $request->task_assigned_to_head,
        ];
        try {
            $task = $this->task->update($task->id, $attributes);

            return back()
                ->with('message', 'Successfully saved')
                ->with('status', 1)
                ->with('task', $task);
        } catch (\Exception $e) {
            return view('task::edit', $task->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Tritiyo\Task\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->task->delete($id);
        TaskMaterial::where('task_id', $id)->delete();
        TaskVehicle::where('task_id', $id)->delete();
        TaskSite::where('task_id', $id)->delete();
        return redirect()->back()->with(['status' => 1, 'message' => 'Successfully deleted']);
    }


    //Vehicle
    public function taskVehicleCreate(Request $request)
    {
        //dd($request->all());
        return view('task::taskvehicle.create');
    }

    public function taskVehicleStore(Request $request)
    {
        dd($request->all());
    }

}
