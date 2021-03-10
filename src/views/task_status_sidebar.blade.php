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


<div class="card tile is-child">

    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="fas fa-tasks default"></i></span>
            Main Task Data
        </p>
    </header>

    <div class="card-content">
        <div class="card-data">

            <div class="columns" style="background: #48c774;">

                <div class="column is-3">Task Type</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->task_type ?? NULL }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Task Name</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->task_name ?? NULL }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Task Code</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->task_code ?? NULL }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Project Manager</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ \App\Models\User::where('id', $task->user_id)->first()->name }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Site Head</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ \App\Models\User::where('id', $task->site_head)->first()->name }}
                </div>
            </div>

            <div class="columns">
                <div class="column is-3">Project Name</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Task Created Time</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->created_at }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Task Details</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->task_details ?? NULL }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">Task Created For</div>
                <div class="column is-1">:</div>
                <div class="column">
                    {{ $task->task_for ?? NULL }}
                </div>
            </div>
            <div class="columns">
                <div class="column is-12">
                    @php
                        $task_sites = DB::select('SELECT site_id FROM `tasks_site` WHERE task_id = '. $task->id .' GROUP BY site_id');
                        $task_resources = DB::select('SELECT resource_id FROM `tasks_site` WHERE task_id = '. $task->id .' GROUP BY resource_id');
                        $task_vehicle = \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task->id)->get();
                        $task_material = \Tritiyo\Task\Models\TaskMaterial::where('task_id', $task->id)->get();
                    @endphp
                    @if(!empty($task_sites))
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th colspan="4">Site and Resource Information</th>
                            </tr>
                            <tr>
                                <th>Task ID</th>
                                <th>Site Code</th>
                                <th>Resource ID</th>
                            </tr>

                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>
                                    @foreach($task_sites as $data)
                                        {{ \Tritiyo\Site\Models\Site::where('id', $data->site_id)->first()->site_code  }}
                                        <br/>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($task_resources as $data)
                                        {{ \App\Models\User::where('id', $data->resource_id )->first()->name }}
                                        <br/>
                                    @endforeach
                                </td>
                            </tr>

                        </table>
                    @endif
                    @if($task_vehicle->count() > 0)
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th colspan="4">Vehicle Information</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Task ID</th>
                                <th>Vehicle</th>
                                <th>Rent</th>
                            </tr>
                            @foreach($task_vehicle as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->task_id }}</td>
                                    <td>{{ \Tritiyo\Vehicle\Models\Vehicle::where('id', $data->vehicle_id)->first()->name  }}</td>
                                    <td>{{ $data->vehicle_rent  }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                    @if($task_material->count() > 0)
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th colspan="4">Material Information</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Task ID</th>
                                <th>Material</th>
                                <th>Quantity</th>
                            </tr>
                            @foreach($task_material as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->task_id }}</td>
                                    <td>{{ \Tritiyo\Material\Models\Material::where('id', $data->material_id)->first()->name  }}</td>
                                    <td>{{ $data->material_qty  }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $taskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                  ->orderBy('id', 'desc')->first();
    $proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
@endphp

@if(auth()->user()->isManager(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id))
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
