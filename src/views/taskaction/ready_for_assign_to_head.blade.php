@if(auth()->user()->isManager(auth()->user()->id))
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title" style="background: lemonchiffon">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Action Panel
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">

                @if($task->task_assigned_to_head == 'Yes')
                    <div class="statusSuccessMessage">
{{--                        $taskStatuss = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)--}}
{{--                        ->orderBy('id', 'desc')->first();--}}
                        {{ \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->orderBy('id', 'desc')->first()->message }}
                    </div>
                @else
                    {{ Form::open(array('url' => route('tasks.update', $task->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
                    {{ Form::hidden('task_id', $task->id ?? '') }}

                    @if(!empty($task))
                        {{ Form::hidden('task_assigned_to_head', 'Yes' ?? '') }}
                        {{ Form::hidden('task_message_handler', 'task_assigned_to_head' ?? '') }}
                        <input type="submit" value="Assign to head" class="button is-success"/>
                    @endif
                @endif
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
