<div class="column is-4">
    <div class="borderedCol">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>
                            <a href="{{ route('tasks.show', $task->id) }}"
                               title="View route">
                                <strong style="color: #555;">TaskName: </strong>
                                {{ $task->task_name }}
                            </a>
                        </strong>
                        <br/>
                        <small>
                            <strong>Project: </strong>
                            @php $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first() @endphp
                            {{  $project->name }}
                        </small>
                        <br/>

                    @php
                        $task_status = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->orderBy('created_at', 'desc')->first();
                    @endphp
                    @if(isset($task_status->message))
                        @if($task_status->code == 'head_declined' || $task_status->code == 'approver_declined' || $task_status->code == 'cfo_declined' || $task_status->code == 'accountant_declined')
                            @php
                                $red = 'statusDangerMessage';
                            @endphp
                        @endif
                        <div class="{{ !empty($red) ? $red : 'statusSuccessMessage' }}">
                            {{ $task_status->message ?? NULL }}
                        </div>

                        @endif
                        </p>
                </div>
                <nav class="level is-mobile">
                    <div class="level-left">
                        <a href="{{ route('tasks.show', $task->id) }}"
                           class="level-item"
                           title="View user data">
                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                        </a>

                        @if (auth()->user()->isManager(auth()->user()->id)  || auth()->user()->isApprover(auth()->user()->id) || auth()->user()->isAdmin(auth()->user()->id))
                            <a href="{{ route('tasks.edit', $task->id) }}"
                               class="level-item"
                               title="View all transaction">
                                                    <span class="icon is-info is-small"><i
                                                            class="fas fa-edit"></i></span>
                            </a>

                            {{--                            {!! delete_data('tasks.destroy',  $task->id) !!}--}}
                        @endif
                    </div>
                </nav>
            </div>
        </article>
    </div>
</div>
