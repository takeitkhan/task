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
            @endif

        @endif
    </div>
@endsection
