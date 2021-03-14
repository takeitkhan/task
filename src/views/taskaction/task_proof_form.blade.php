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
                            <input name="resource_proof[]" type="file" id="resource_proof" multiple/>
                        </div>
                    @endif
                </div>
                <div class="columns">
                    <div class="column is-2">Vehicle Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="vehicle_proof[]" type="file" id="vehicle_proof" multiple/>
                        </div>
                    @endif
                </div>
                <div class="columns">
                    <div class="column is-2">Material Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="material_proof[]" type="file" id="material_proof" multiple/>
                        </div>
                    @endif
                </div>

                <div class="columns">
                    <div class="column is-2">Anonymous Proof</div>
                    <div class="column is-1">:</div>
                    @if(auth()->user()->isResource(auth()->user()->id) )
                        <div class="column">
                            <input name="anonymous_proof[]" type="file" id="anonymous_proof" multiple/>
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        function upload(arg, id){
            var files = arg.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    console.log(files[0]);
                    $("<span class=\"pip\">" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + files[0].name + "\"/>" +
                        "<br/><span class=\"remove\">Remove image</span>" +
                        "</span>").insertAfter(id);
                    $(".remove").click(function(){
                        $(this).parent(".pip").remove();
                        $(id).val("");
                    });

                });
                fileReader.readAsDataURL(f);
            }
        }
        if (window.File && window.FileList && window.FileReader) {
            $("#resource_proof").on("change", function(e) {
               upload(e, this)
            });
            $("#vehicle_proof").on("change", function(e) {
                upload(e, this)
            });
            $("#material_proof").on("change", function(e) {
                upload(e, this)
            });
            $("#anonymous_proof").on("change", function(e) {
                upload(e, this)
            });
        } else {
            alert("Your browser doesn't support to File Upload")
        }
    });
</script>
<style>
    input[type="file"] {
        display: block;
    }
    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }
    .remove:hover {
        background: white;
        color: black;
    }
</style>

