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

@section('column_left')
    <div class="columns is-multiline">
        @if(!empty($tasks))
            @foreach($tasks as $task)
             

                @if($task->user_id == auth()->user()->id || $task->site_head == auth()->user()->id)
                    <div class="column is-4">
                        <div class="borderedCol">
                            <article class="media">
                                <div class="media-content">
                                    <div class="content">
                                        <p>
                                            <strong>
                                                <a href="{{ route('tasks.show', $task->id) }}"
                                                   title="View route">
                                                    <strong style="color: #555;">Task Name: </strong> {{ $task->task_name }}
                                                </a>
                                            </strong>
                                            <br/>
                                            <small>
                                                <strong>Project: </strong>
                                                @php $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first() @endphp
                                                {{  $project->name }}
                                            </small>
                                            
                                        </p>
                                    </div>
                                    <nav class="level is-mobile">
                                        <div class="level-left">
                                            <a href="{{ route('tasks.show', $task->id) }}"
                                               class="level-item"
                                               title="View user data">
                                                <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                            </a>

                                            @if (auth()->user()->isManager(auth()->user()->id) || auth()->user()->isAdmin(auth()->user()->id))
                                                <a href="{{ route('tasks.edit', $task->id) }}"
                                                   class="level-item"
                                                   title="View all transaction">
                                                    <span class="icon is-info is-small"><i
                                                            class="fas fa-edit"></i></span>
                                                </a>

                                                {!! delete_data('tasks.destroy',  $task->id) !!}
                                            @endif
                                        </div>
                                    </nav>
                                </div>
                            </article>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
