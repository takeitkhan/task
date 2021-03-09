<?php

namespace Tritiyo\Task\Controllers;

use Tritiyo\Task\Helpers\TaskHelper;
use Tritiyo\Task\Models\TaskRequisitionBill;
use Tritiyo\Task\Repositories\TaskRequisitionBill\TaskRequisitionBillInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TaskRequisitionBillController extends Controller
{
    /**
     * @var TaskSiteInterface
     */
    private $taskrequisitionbill;

    /**
     * RoutelistController constructor.
     * @param TaskRequisitionBillInterface $taskrequisitionbill
     */
    public function __construct(TaskRequisitionBillInterface $taskrequisitionbill)
    {
        $this->taskrequisitionbill = $taskrequisitionbill;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskrequisitionbills = $this->tasksite->getAll();
        return view('task::index', ['taskrequisitionbills' => $taskrequisitionbills]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task::taskrequisitionbill.create');
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
            ]
        );
        $task_id = $request->task_id;
        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else{
            // store
            $chunck = [
                'task' => \Tritiyo\Task\Models\Task::where('id', $task_id)->get()->toArray(),
                'task_site' => \Tritiyo\Task\Models\TaskSite::where('task_id', $task_id)->get()->toArray(),
                'task_vehicle' => \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task_id)->get()->toArray(),
                'task_material' => \Tritiyo\Task\Models\TaskMaterial::where('task_id', $task_id)->get()->toArray(),
                'task_regular_amount' => array(
                    'da' => array(
                        'da_amount' => $request->get('da_amount'),
                        'da_notes' => $request->get('da_notes')
                    ),
                    'labour' => array(
                        'labour_amount' => $request->get('labour_amount'),
                        'labour_notes' => $request->get('labour_notes')
                    ),
                    'other' => array(
                        'other_amount' => $request->get('other_amount'),
                        'other_notes' => $request->get('other_notes')
                    )
                ),
                'task_transport_breakdown' => $request->get('transport'),
                'task_purchase_breakdown' => $request->get('purchase')
            ];
            $chunck = TaskRequisitionBill::updateOrCreate(
                array('task_id' => $task_id),
                array('requisition_prepared_by_manager' => json_encode($chunck))
            );

            //dd($chunck);

            try {
                //  $taskrequisitionbill = $this->tasksite->create($arr);
                //return view('task::create', ['task' => $taskrequisitionbill]);
                return redirect()->back()->with(['status' => 1, 'message' => 'Successfully Saved']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskrequisitionbill
     * @return \Illuminate\Http\Response
     */
    public function show(TaskSite $taskrequisitionbill)
    {
        return view('task::show', ['task' => $taskrequisitionbill]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Tritiyo\Task\Models\Task $taskrequisitionbill
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskRequisitionBill $taskrequisitionbill)
    {
        return view('task::taskrequisitionbill.create', ['taskrequisitionbill' => $taskrequisitionbill]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Tritiyo\Task\Models\Task $taskrequisitionbill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (auth()->user()->isApprover(auth()->user()->id)) {
            TaskHelper::statusUpdateOrInsert([
                'code' => TaskHelper::getStatusKey('task_approver_edited'),
                'task_id' => $request->task_id,
                'action_performed_by' => auth()->user()->id,
                'performed_for' => null,
                'requisition_id' => null,
                'message' => TaskHelper::getStatusMessage('task_approver_edited')
            ]);
        }
        //dd($request->all());
        if($request->vehicle_id){
            $t = TaskRequisitionBill::where('task_id', $request->task_id);
            $t->delete();
            foreach ($request->vehicle_id as $key => $row) {
                $attributes = [
                    'task_id' => $request->task_id,
                    'vehicle_id' => $request->vehicle_id[$key],
                    'vehicle_rent' => $request->vehicle_rent[$key],
                    'vehicle_note' => $request->vehicle_note[$key],
                ];
                $taskrequisitionbill = $this->taskrequisitionbill->create($attributes);
            }
        }
        //dd($request->all());
        try {
            //$taskrequisitionbill = $this->task->update($taskrequisitionbill->id, $attributes);

            return back()->with('message', 'Successfully saved')->with('status', 1);
            // ->with('task', $taskrequisitionbill);
        } catch (\Exception $e) {
            return view('task::edit', $taskrequisitionbill->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Tritiyo\Task\Models\Task $taskrequisitionbill
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->taskrequisitionbill->delete($id);
        return redirect()->back()->with(['status' => 1, 'message' => 'Successfully deleted']);
    }

}
