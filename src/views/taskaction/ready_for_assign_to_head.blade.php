@if($task->task_assigned_to_head == 'Yes')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        // $('form#requisition_form input').attr('disabled', true);
        // $('form#requisition_form button').addClass('is-hidden');
        $('form#add_route button').addClass('is-hidden');
        $('form#add_route input').attr('disabled', true);
        $('form#add_route textarea').attr('disabled', true);
    </script>
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
