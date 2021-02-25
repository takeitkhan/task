@extends('layouts.app')

@section('title')
    Single Task
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Single Task',
            'spSubTitle' => 'view a Task',
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
            'spPlaceholder' => 'Search sites...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    {{--    <article class="panel is-primary">--}}
    {{--        <div class="customContainer">--}}
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Main Task Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Project Name</div>
                    <div class="column is-1">:</div>
                    <div class="column">
                        
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-2">Loccation</div>
                    <div class="column is-1">:</div>
                    <div class="column"></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Site Code</div>
                    <div class="column is-1">:</div>
                    <div class="column"></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Budget</div>
                    <div class="column is-1">:</div>
                    <div class="column"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('column_right')
   
@endsection
@section('cusjs')
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
@endsection
