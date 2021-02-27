<div class="card tile is-child">
    <header class="card-header">
        <p class="card-header-title" style="background: lemonchiffon">
            <span class="icon"><i class="fas fa-tasks default"></i></span>
            Proof Images Panel
        </p>
    </header>

    <div class="card-content">
        <div class="card-data">
            @if(!empty($taskStatus) && $taskStatus->code == 'head_accepted' && auth()->user()->id == $taskStatus->action_performed_by)
                <div class="notification is-success">
                    Task Accepted. Please submit your proof
                </div>
            @endif
            <div class="columns">
                <div class="column is-2">Resource Proof</div>
                <div class="column">
                    @if(($proofs != NULL))
                        <img src="{{ url('public/proofs/' .  $proofs->resource_proof ) }}"
                             width="250"/>
                    @endif
                </div>
            </div>
            <div class="columns">
                <div class="column is-2">Vehicle Proof</div>
                <div class="column">
                    @if(($proofs != NULL))
                        <img src="{{ url('public/proofs/' . $proofs->vehicle_proof ) }}"
                             width="250"/>
                    @endif
                </div>
            </div>
            <div class="columns">
                <div class="column is-2">Material Proof</div>
                <div class="column">
                    @if(($proofs != NULL))
                        <img src="{{ url('public/proofs/' . $proofs->material_proof) }}"
                             width="250"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
