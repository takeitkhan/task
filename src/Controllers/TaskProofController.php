<?php

namespace Tritiyo\Task\Controllers;

use Tritiyo\Task\Models\TaskProof;
use Tritiyo\Task\Helpers\TaskHelper;
use Tritiyo\Task\Repositories\TaskProof\TaskProofInterface;
use Tritiyo\Task\Repositories\TaskStatus\TaskStatusInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TaskProofController extends Controller
{
    /**
     * @var TaskSiteInterface
     */
    private $taskproof;

    /**
     * @var TaskSiteInterface
     */
    private $taskstatus;

    /**
     * RoutelistController constructor.
     * @param TaskProofInterface $taskproof
     * @param TaskStatusInterface $taskstatus
     */
    public function __construct(TaskProofInterface $taskproof, TaskStatusInterface $taskstatus)
    {
        $this->taskproof = $taskproof;
        $this->taskstatus = $taskstatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskproofs = $this->tasksite->getAll();
        return view('task::index', ['tasksites' => $taskproofs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task::taskproof.create');
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
        if (isset($request->task_id)) {

            $request->validate([
                'resource_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg', //|max:2048,
                'vehicle_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg', //|max:2048,
                'material_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg' //|max:2048,
            ]);

            $resource_proof = time() . $request->resource_proof->getClientOriginalName();
            $vehicle_proof = time() . $request->vehicle_proof->getClientOriginalName();
            $material_proof = time() . $request->material_proof->getClientOriginalName();

            $resource_proof_data = $request->resource_proof->move(public_path('proofs/' . date('Y') . date('m')), $resource_proof);
            $vehicle_proof_data = $request->vehicle_proof->move(public_path('proofs/' . date('Y') . date('m')), $vehicle_proof);
            $material_proof_data = $request->material_proof->move(public_path('proofs/' . date('Y') . date('m')), $material_proof);

            $attributes = [
                'task_id' => $request->task_id,
                'proof_sent_by' => auth()->user()->id,
                'resource_proof' => date('Y') . date('m') . '/' . $resource_proof,
                'vehicle_proof' => date('Y') . date('m') . '/' . $vehicle_proof,
                'material_proof' => date('Y') . date('m') . '/' . $material_proof,
                'lat_proof' => null,
                'long_proof' => null
            ];
            //dd($attributes);
            $taskproof = $this->taskproof->create($attributes);

            TaskHelper::statusUpdate([
                'code' => TaskHelper::getStatusKey(2),
                'task_id' => $request->task_id,
                'action_performed_by' => auth()->user()->id,
                'performed_for' => null,
                'requisition_id' => null,
                'message' => TaskHelper::getStatusMessage(2)
            ]);

            if ($taskproof == true) {
                return back()
                    ->with('success', 'You have successfully upload image.');
            }
        } else {
            return 'You have not posted any proof under this task.';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskproof
     * @return \Illuminate\Http\Response
     */
    public function show(TaskSite $taskproof)
    {
        return view('task::show', ['task' => $taskproof]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskproof
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskSite $taskproof)
    {
        return view('task::taskproof.create', ['task' => $taskproof]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Tritiyo\Task\Models\Task $taskproof
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());

        $t = TaskProof::where('task_id', $request->task_id);
        $t->delete();
        foreach ($request->vehicle_id as $key => $row) {
            $attributes = [
                'task_id' => $request->task_id,
                'vehicle_id' => $request->vehicle_id[$key],
                'vehicle_rent' => $request->vehicle_rent[$key],
            ];
            $taskproof = $this->taskproof->create($attributes);
        }
        //dd($request->all());
        try {
            //$taskproof = $this->task->update($taskproof->id, $attributes);

            return back()->with('message', 'Successfully saved')->with('status', 1);
            // ->with('task', $taskproof);
        } catch (\Exception $e) {
            return view('task::edit', $taskproof->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Tritiyo\Task\Models\Task $taskproof
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->task->delete($id);
        return redirect()->back()->with(['status' => 1, 'message' => 'Successfully deleted']);
    }

    public function taskSitebyTaskId($id)
    {
        $taskSites = TaskSite::where('task_id', $id)->get();
        $taskId = $id;
        return view('task::tasksite.create', compact('taskSites', 'taskId'));
        // }
    }

}
