@extends('layouts.app')

@section('title')
    Tasks
@endsection

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
            'spAddUrl' => route('tasks.create'),
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
                <div class="column is-4">
                    <div class="borderedCol">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <a href="{{ route('tasks.show', $task->id) }}"
                                               title="View route">
                                               <strong>Task Code: </strong>  {{ $task->task_code }},
                                            </a>
                                        </strong>
                                        <br/>
                                        <small>
                                            <strong>Project: </strong> 
                                            @php $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first() @endphp
                                            {{  $project->name }}
                                        </small>
                                        <br/>
                                        <small>
                                            <strong>Site: </strong> 
                                            
                                        </small>
                                        <br/>
                                    </p>
                                </div>
                                <nav class="level is-mobile">
                                    <div class="level-left">
                                        <a href="{{ route('tasks.show', $task->id) }}"
                                           class="level-item"
                                           title="View user data">
                                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                        </a>
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                           class="level-item"
                                           title="View all transaction">
                                            <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                        </a>                                        

                                        {!! delete_data('tasks.destroy',  $task->id) !!}
                                    </div>
                                </nav>
                            </div>
                        </article>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
