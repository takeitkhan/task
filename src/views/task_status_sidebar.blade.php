{{--    <article class="panel is-primary">--}}
{{--        <div class="customContainer">--}}

@if(auth()->user()->isManager(auth()->user()->id))
    {{--    @include('task::taskaction.ready_for_assign_to_head')--}}
@endif
@if(auth()->user()->isApprover(auth()->user()->id))
    {{--    @include('task::taskaction.task_approver_accept_decline')--}}
@endif


@include('task::taskaction.accept_decline')


{{--{!! Tritiyo\Task\Helpers\TaskHelper::actionHelper('task_approver_edited', true, true)  !!}--}}
@php
    $task_sites = DB::select('SELECT site_id FROM `tasks_site` WHERE task_id = '. $task->id .' GROUP BY site_id');
    $task_resources = DB::select('SELECT resource_id FROM `tasks_site` WHERE task_id = '. $task->id .' GROUP BY resource_id');
    $task_vehicle = \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task->id)->get();
    $task_material = \Tritiyo\Task\Models\TaskMaterial::where('task_id', $task->id)->get();
@endphp
<div class="card tile is-child quick_view">

    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="fas fa-tasks default"></i></span>
            Main Task Data
        </p>
    </header>

    <div class="card-content">
        <div class="card-data">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>
                    <th colspan="4">Task General Information</th>
                </tr>
                <tr>
                    <td><strong>Task Type</strong></td>
                    <td><span style="background: #48c774; padding: 3px;">{{ $task->task_type ?? NULL }}</span></td>
                    <td><strong>Task Name</strong></td>
                    <td>{{ $task->task_name ?? NULL }}</td>
                </tr>
                <tr>
                    <td><strong>Task Code</strong></td>
                    <td colspan="3">{{ $task->task_code ?? NULL }}</td>
                </tr>
                <tr>
                    <td><strong>Task Created Time</strong></td>
                    <td>{{ $task->created_at }}</td>
                    <td><strong>Task Created For</strong></td>
                    <td>{{ $task->task_for ?? NULL }}</td>
                </tr>
                <tr>
                    <td><strong>Project Name</strong></td>
                    <td>{{ \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name }}</td>
                    <td><strong>Project Manager</strong></td>
                    <td>{{ \App\Models\User::where('id', $task->user_id)->first()->name }}</td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Task Details</strong></td>
                </tr>
                <tr>
                    <td colspan="4">{{ $task->task_details ?? NULL }}</td>
                </tr>
                @if(!empty($task_sites))
                    <tr>
                        <td colspan="4"><strong>Site and resource information</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            @foreach($task_sites as $data)
                                {{ \Tritiyo\Site\Models\Site::where('id', $data->site_id)->first()->site_code  }}
                                <br/>
                            @endforeach
                        </td>
                        <td colspan="2">
                            @foreach($task_resources as $data)
                                {{ \App\Models\User::where('id', $data->resource_id )->first()->name }}
                                <br/>
                            @endforeach
                        </td>
                    </tr>
                @endif
                @if($task_vehicle->count() > 0 || $task_material->count() > 0)
                    <tr>
                        <td colspan="2"><strong>Vehicle information</strong></td>
                        <td colspan="2"><strong>Material information</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                <tr>
                                    <td>Name</td>
                                    <td>Rent</td>
                                </tr>
                                @foreach($task_vehicle as $data)
                                    <tr>
                                        <td>{{ \Tritiyo\Vehicle\Models\Vehicle::where('id', $data->vehicle_id)->first()->name  }}</td>
                                        <td>{{ $data->vehicle_rent  }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td colspan="2">
                            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                <tr>
                                    <td>Material</td>
                                    <td>Amount</td>
                                </tr>
                                @foreach($task_material as $data)
                                    <tr>
                                        <td>{{ \Tritiyo\Material\Models\Material::where('id', $data->material_id)->first()->name  }}</td>
                                        <td>{{ $data->material_qty  }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                @endif
            </table>
        </div>
    </div>
</div>

@php
    $taskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                  ->orderBy('id', 'desc')->first();
    $proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
@endphp

@if(auth()->user()->isManager(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id))
    @include('task::taskaction.task_proof_images')
@else
    @if(empty($taskStatus) || $taskStatus->code == 'declined' && auth()->user()->isResource(auth()->user()->id))
        @include('task::taskaction.task_accept_decline')
    @elseif(empty($taskStatus) || $taskStatus->code == 'head_accepted')
        @include('task::taskaction.task_proof_form')
    @elseif(empty($taskStatus) || $taskStatus->code == 'proof_given')
        @include('task::taskaction.task_proof_images')
    @endif
@endif


<style type="text/css">
    .tile.is-child.quick_view {
        margin-top: 15px !important;
    }

    .quick_view, .quick_view table {
        font-size: 12px;
    }

    .quick_view table th {
        color: darkblue;
    }
</style>

