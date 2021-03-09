@php
    $taskproofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->get();
@endphp
@if($taskproofs->count() > 0)
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
                            @foreach(explode(' | ', $proofs->resource_proof) as $key => $img_link)
                            <figure class="image is-128x128 is-inline-block">
                                <a class="modal-button" data-target="resource_proof{{$key}}">
                                    <img src="{{ url('public/proofs/' .   $img_link) }}"  class="image_wrap"/>
                                </a>
                                <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('resource_proof'.$key, url('public/proofs/' .   $img_link) );?>
                            </figure>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-2">Vehicle Proof</div>
                    <div class="column">
                        @if(($proofs != NULL))
                            @foreach(explode(' | ', $proofs->vehicle_proof) as $key => $img_link)
                                <figure class="image is-128x128 is-inline-block">
                                    <a class="modal-button" data-target="vehicle_proof{{$key}}">
                                        <img src="{{ url('public/proofs/' .   $img_link) }}"  class="image_wrap"/>
                                    </a>
                                    <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('vehicle_proof'.$key, url('public/proofs/' .   $img_link) );?>
                                </figure>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-2">Material Proof</div>
                    <div class="column">
                        @if(($proofs != NULL))
                            @foreach(explode(' | ', $proofs->material_proof) as $key => $img_link)
                                <figure class="image is-128x128 is-inline-block">
                                    <a class="modal-button" data-target="material_proof{{$key}}">
                                        <img src="{{ url('public/proofs/' .   $img_link) }}"  class="image_wrap"/>
                                    </a>
                                    <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('material_proof'.$key, url('public/proofs/' .   $img_link) );?>
                                </figure>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-2">Anonymous Proof</div>
                    <div class="column">
                        @if(($proofs != NULL))
                            @foreach(explode(' | ', $proofs->anonymous_proof) as $key => $img_link)
                                <figure class="image is-128x128 is-inline-block">
                                    <a class="modal-button" data-target="anonymous_proof{{$key}}">
                                        <img src="{{ url('public/proofs/' .   $img_link) }}"  class="image_wrap"/>
                                    </a>
                                    <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('anonymous_proof'.$key, url('public/proofs/' .   $img_link) );?>
                                </figure>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
<script type="text/javascript" src="https://unpkg.com/bulma-modal-fx/dist/js/modal-fx.min.js"></script>
<style>
    img.image_wrap{
        height: 100px;
        width: 250px;
        background: #f3f3f3;
        padding: 10px;
    }
</style>
