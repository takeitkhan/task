<br/>

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
                @if(!empty($taskStatus) && $taskStatus->code == 'head_accepted' && auth()->user()->id == $taskStatus->action_performed_by)
                    <div class="notification is-success">
                        Task Accepted. Please submit your proof
                    </div>
                @endif
                {{ Form::open(array('url' => route('taskproof.store'), 'method' => 'POST', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off')) }}
                {{ Form::hidden('task_id', $task->id ?? '') }}
                <div class="columns">
                    <div class="column is-2">Resource Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="resource_proof" type="file"/>
                        </div>
                    @endif
                </div>
                <div class="columns">
                    <div class="column is-2">Vehicle Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="vehicle_proof" type="file"/>
                        </div>
                    @endif
                </div>
                <div class="columns">
                    <div class="column is-2">Material Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="material_proof" type="file"/>
                        </div>
                    @endif
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-success is-small">Submit Proof</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
