@extends('layouts.app')

@section('title')
    Single Task
@endsection

@php
    if (auth()->user()->isManager(auth()->user()->id)) {
        $addbtn = route('tasks.create');
        $alldatas = route('tasks.index');
    } else {
        $addbtn = '#';
        $alldatas = '#';
    }
@endphp
<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Single Task',
            'spSubTitle' => 'view a Task',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addbtn,
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search sites...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    {{--    <article class="panel is-primary">--}}
    {{--        <div class="customContainer">--}}
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
                    <div class="column is-2">Task Type</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ $task->task_type ?? NULL }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Task Name</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ $task->task_name ?? NULL }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Task Code</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ $task->task_code ?? NULL }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Project Manager</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ \App\Models\User::where('id', $task->user_id)->first()->name }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Site Head</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ \App\Models\User::where('id', $task->site_head)->first()->name }}
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-2">Project Name</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Task Created Time</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        {{ $task->created_at }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Task Details</div>
                    <div class="column is-1">:</div>
                </div>
                <div class="columns">
                    <div class="column is-12">
                        {{ $task->task_details ?? NULL }}
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-12">
                        @php
                            $task_sites = \Tritiyo\Task\Models\TaskSite::where('task_id', $task->id)->get();
                            $task_vehicle = \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task->id)->get();
                            $task_material = \Tritiyo\Task\Models\TaskMaterial::where('task_id', $task->id)->get();
                        @endphp

                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th colspan="4">Site and Resource Information</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Task ID</th>
                                <th>Site Code</th>
                                <th>Resource ID</th>
                            </tr>
                            @foreach($task_sites as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->task_id }}</td>
                                    <td>{{ \Tritiyo\Site\Models\Site::where('id', $data->site_id)->first()->site_code  }}</td>
                                    <td>{{ \App\Models\User::where('id', $data->resource_id )->first()->name }}</td>
                                </tr>
                            @endforeach
                        </table>


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

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    @php
        $proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
        //dd($proofs);
    @endphp
    @if(auth()->user()->isResource(auth()->user()->id))
        <div class="card tile is-child">
            <header class="card-header">
                <p class="card-header-title" style="background: lemonchiffon">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                    Submit Proof
                </p>
            </header>

            <div class="card-content">
                <div class="card-data">
                    {{ Form::open(array('url' => route('taskproof.store'), 'method' => 'POST', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
                    {{ Form::hidden('task_id', $task->id ?? '') }}
                    <div class="columns">
                        <div class="column is-2">Resource Proof</div>
                        <div class="column is-1">:</div>
                        <div class="column">
                            <input name="resource_proof" type="file"/>
                        </div>
                        <div class="column">
                            @if(($proofs != NULL))
                            <img  src="{{ url('public/proofs/' .  $proofs->resource_proof ) }}"
                                width=""/>
                            @endif
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">Vehicle Proof</div>
                        <div class="column is-1">:</div>
                        <div class="column">
                            <input name="vehicle_proof" type="file"/>
                        </div>
                        <div class="column">
                            @if(($proofs != NULL))
                            <img  src="{{ url('public/proofs/' . $proofs->vehicle_proof ) }}"
                                width=""/>
                            @endif
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">Material Proof</div>
                        <div class="column is-1">:</div>
                        <div class="column">
                            <input name="material_proof" type="file"/>
                        </div>
                        <div class="column">
                            @if(($proofs != NULL))
                            <img  src="{{ url('public/proofs/' . $proofs->material_proof) }}"
                                width=""/>
                            @endif
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field is-grouped">
                                <div class="control">
                                    <button class="button is-success is-small">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endif
@endsection

@section('column_right')

@endsection
@section('cusjs')
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
@endsection
