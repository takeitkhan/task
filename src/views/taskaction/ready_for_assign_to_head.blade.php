@if($task->task_assigned_to_head == 'Yes')

    @else
        {{ Form::open(array('url' => route('tasks.update', $task->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
        {{ Form::hidden('task_id', $task->id ?? '') }}

        @if(!empty($task))
            {{ Form::hidden('task_assigned_to_head', 'Yes' ?? '') }}
            {{ Form::hidden('task_message_handler', 'task_assigned_to_head' ?? '') }}
            <input type="submit" value="Assign to head" class="button is-success"/>
        @endif
        {{ Form::close() }}
@endif
