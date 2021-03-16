@extends('layouts.app')

@section('title')
    Tasks
@endsection

@php
    if (auth()->user()->isManager(auth()->user()->id)) {
        $addbtn = route('tasks.create');
    } else {
        $addbtn = '#';
        $alldatas = '#';
    }
@endphp

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Tasks',
            'spSubTitle' => 'all tasks here',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addbtn,
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'Tasks',
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
{{-- ||--}}
<?php
function userAccess($arg)
{
    return auth()->user()->$arg(auth()->user()->id);
}
?>
@section('column_left')
    <div class="columns is-multiline">
        @if(!empty($tasks))
            @if(auth()->user()->isResource(auth()->user()->id))
                @foreach($tasks->where('task_assigned_to_head', 'Yes') as $task)
                    @if($task->user_id == auth()->user()->id || $task->site_head == auth()->user()->id)
                        @include('task::tasklist.index_template')
                    @endif
                @endforeach
            @elseif(auth()->user()->isApprover(auth()->user()->id))
                @foreach($tasks->where('task_assigned_to_head', 'Yes') as $task)
                    @php
                        $proof_check = \Tritiyo\Task\Models\TaskStatus::where('code', 'proof_given')->where('task_id', $task->id)->first();
                        //dump($proof_check);
                    @endphp
                    @if($proof_check != null && $proof_check->code)
                        @include('task::tasklist.index_template')
                    @endif
                @endforeach
            @elseif(auth()->user()->isManager(auth()->user()->id))
                @foreach($tasks->where('user_id', auth()->user()->id) as $task)
                    @include('task::tasklist.index_template')
                @endforeach

                {{--   Cfo--}}
            @elseif(auth()->user()->isCFO(auth()->user()->id))
                @php
                    $getCFOTask =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                    ->where('tasks_requisition_bill.requisition_submitted_by_manager', 'Yes')
                                    ->paginate('18');
                    //dd($getCFOTask);
                @endphp

                @foreach($getCFOTask as $task)
                    @include('task::tasklist.index_template')
                @endforeach

                <div class="pagination_wrap pagination is-centered">
                    {{$getCFOTask->links('pagination::bootstrap-4')}}
                </div>

                {{--  Accountant          --}}
            @elseif(auth()->user()->isAccountant(auth()->user()->id))
                @php
                    $getAccountantTask =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                    ->where('tasks_requisition_bill.requisition_approved_by_cfo', 'Yes')
                                    ->paginate('18');
                    //dd($getCFOTask);
                @endphp

                @foreach($getAccountantTask as $task)
                    @include('task::tasklist.index_template')
                @endforeach

                <div class="pagination_wrap pagination is-centered">
                    {{$getAccountantTask->links('pagination::bootstrap-4')}}
                </div>



                {{--   End         --}}
            @endif
        @endif
    </div>
    <div class="pagination_wrap pagination is-centered">
        {{$tasks->links('pagination::bootstrap-4')}}
    </div>

@endsection
