@if(auth()->user()->isApprover(auth()->user()->id))
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title" style="background: lemonchiffon">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Task Approval Panel
            </p>
        </header>
        @php
            $taskStatuss = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                                  ->orderBy('id', 'desc')->first();
        @endphp
        <div class="card-content">
            <div class="card-data">
                {{ Form::open(array('url' => route('taskstatus.store'), 'method' => 'POST', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
                {{ Form::hidden('task_id', $task->id ?? '') }}


                @if(!empty($taskStatus) && $taskStatus->code == 'declined' && auth()->user()->id == $taskStatus->action_performed_by)
                    <button class="button is-danger">Task Declined</button>
                    
                @elseif(!empty($taskStatuss)  && $taskStatuss->code == 'task_approver_edited')
                    <?php echo Tritiyo\Task\Helpers\TaskHelper::buttonInputApproveDecline('approver_approved', 'approver_declined');?>

                @elseif(!empty($taskStatuss)  && $taskStatuss->code == 'approver_approved')
                    <button class="button is-success">Task Approved</button>

                @elseif(!empty($taskStatuss)  && $taskStatuss->code == 'approver_declined')
                <button class="button is-danger">Task Declined</button>

                @else
                    <?php echo Tritiyo\Task\Helpers\TaskHelper::buttonInputApproveDecline('approver_approved', 'approver_declined');?>
                @endif

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
