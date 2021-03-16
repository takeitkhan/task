@extends('layouts.app')
@section('title')
    Include site information for task
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'include Site Of Task',
            'spSubTitle' => 'Add a Site of task',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    <article class="panel is-primary" id="app">
        <?php
        $task_id = request()->get('task_id');
        if (empty($taskSites)) {
            $taskId = $task_id; //taskId variable asign in tasksite controller
        }
        //$taskId = !empty($task_id) ?? $task_id;
        ?>

            @include('task::layouts.tab')

        <div class="customContainer">
            <?php
            if (!empty($tasksite) && $tasksite->id) {
                $routeUrl = route('tasksites.update', $task->id);
                $method = 'PUT';
            } elseif (!empty($taskId)) {
                $routeUrl = route('tasksites.update', $taskId);
                $method = 'PUT';
            } else {
                $routeUrl = route('tasksites.store');
                $method = 'post';
            }
            ?>
            {{ Form::open(array('url' => $routeUrl, 'method' => $method, 'value' => 'PATCH', 'id' => 'add_route', 'class' => 'task_site_table',  'files' => true, 'autocomplete' => 'off')) }}

            @if($task_id)
                {{ Form::hidden('task_id', $task_id ?? '') }}
            @endif
            @if(!empty($taskId))
                {{ Form::hidden('task_id', $taskId ?? '') }}
            @endif

            <div class="columns">
                <div class="column is-6">

                    <div class="field">

                        {{ Form::label('site_id', 'Sites', array('class' => 'label')) }}
                        <div class="control">
                            <div dclass="select is-multiple">
                                @php $sites = \Tritiyo\Site\Models\Site::get() @endphp
                                <select id="site_select" multiple="multiple" name="site_id[]" class="input" required>
                                    @foreach($sites as $site)
                                        <option value="{{$site->id}}"

                                        @if(isset($taskSites))
                                            @foreach($taskSites as $data)
                                                {{$data->site_id == $site->id ? 'selected' : ''}}
                                                @endforeach
                                            @endif

                                        >{{ $site->site_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('resource_id', 'Site Resources', array('class' => 'label')) }}
                        <div class="control">
                            <div sclass="select is-multiple">

                                @php
                                    $site_head_id = \Tritiyo\Task\Models\Task::select('site_head')->where('id', $taskId)->first();
                                    $resources = \App\Models\User::where('role', '2')->select('name', 'id')
                                    ->whereNotIn('id', array($site_head_id->site_head))
                                    ->get();
                                @endphp
                                <select id='resource_select' multiple="multiple" name="resource_id[]" class="input"
                                        required>
                                    @foreach($resources as $resource)
                                        <option value="{{$resource->id}}"
                                        @if(isset($taskSites))
                                            @foreach($taskSites as $data)
                                                {{$data->resource_id == $resource->id ? 'selected' : ''}}
                                                @endforeach
                                            @endif
                                        >
                                            {{ $resource->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
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
    </article>
@endsection

@section('column_right')
    @php
        $task = \Tritiyo\Task\Models\Task::where('id', $taskId)->first();
    @endphp
    @include('task::task_status_sidebar')
@endsection


@section('cusjs')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#resource_select').select2({
                placeholder: "Select Resource",
                allowClear: true
            });
            $('#site_select').select2({
                placeholder: "Select Site",
                allowClear: true
            });
        });
    </script>

@endsection
