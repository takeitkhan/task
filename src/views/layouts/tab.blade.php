<?php
if(request()->get('task_id')){
    $task_id = request()->get('task_id');
} elseif(!empty($task)){
    $task_id = $task->id;
}


$taskInformation = 'taskinformation';
$siteInformation = 'siteinformation';
$vehicleInformation = 'vehicleinformation';
$materialInformation = 'materialInformation';
$anonymousProofInformation = 'anonymousproof';
$requisitionbillInformation = 'requisitionbillInformation';

?>

<div class="panel-tabs">
    <a class="{{request()->get('information') == $taskInformation ? 'is-active' : ''}}" href="{{route('tasks.edit', $task_id) }}?task_id={{$task_id}}&information={{$taskInformation}}">Task Information</a>
    <a class="{{request()->get('information') == $anonymousProofInformation ? 'is-active' : ''}}" href="{{route('tasks.anonymousproof.edit', $task_id)}}?task_id={{$task_id}}&information={{$anonymousProofInformation}}" class="">Anonymous Proof</a>
    <a class="{{request()->get('information') == $siteInformation ? 'is-active' : ''}}" href="{{route('tasks.site.edit', $task_id) }}?task_id={{$task_id}}&information={{$siteInformation}}" >Site Information</a>
    <a class="{{request()->get('information') == $vehicleInformation ? 'is-active' : ''}}" href="{{route('taskvehicle.create')}}?task_id={{$task_id}}&information={{$vehicleInformation}}" class="">Vehicle Information</a>
    <a class="{{request()->get('information') == $materialInformation ? 'is-active' : ''}}" href="{{route('taskmaterial.create')}}?task_id={{$task_id}}&information={{$materialInformation}}" class="">Material Information</a>

    <?php
        $taskStsApproverApproved = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task_id)->get();
        $collection = Tritiyo\Task\Helpers\TaskHelper::arrayExist($taskStsApproverApproved, 'code', 'approver_approved');
    ?>
    @if($collection == true)
    <a class="{{request()->get('information') == $requisitionbillInformation ? 'is-active' : ''}}" href="{{route('taskrequisitionbill.create')}}?task_id={{$task_id}}&information={{$requisitionbillInformation}}" class="">Requisition Information</a>
    @endif

</div>

