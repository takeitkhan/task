@extends('layouts.app')


@section('column_left')
    <?php
    $today = date('Y-m-d');
    $resourcesAvailable = \DB::select("SELECT * FROM (SELECT *, (SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS site_head,
                    (SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS manager,
                    (SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND DATE_FORMAT(`tasks_site`.`created_at`, '%Y-%m-%d') = '$today' GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                    users.id AS useriddddd
                    FROM users WHERE users.role = 2) AS mm WHERE mm.site_head IS NULL AND mm.resource_used IS NULL");

    $resourcesBooked = \DB::select("SELECT * FROM (SELECT *, (SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS site_head,
                    (SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS manager,
                    (SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND DATE_FORMAT(`tasks_site`.`created_at`, '%Y-%m-%d') = '$today' GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                    users.id AS useriddddd
                    FROM users WHERE users.role = 2) AS mm WHERE mm.site_head IS NOT NULL OR mm.resource_used IS NOT NULL");

    ?>
    <div class="columns is-vcentered  pt-2">
        <div class="column is-6 mx-auto">
            <div class="card tile is-child xquick_view">
                <div class="card-content">
                    <div class="card-data">
                            <div class="columns">
                                <div class="column is-4 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-primary-dark">A Resource or Site Head is Avaialble for today</th>
                                        </tr>
                                        @foreach($resourcesAvailable as $user)
                                            <tr>
                                                <td style="text-align: center">
                                                   <a target="_blank" href="{{route('hidtory.user', $user->id)}}">{{ $user->name }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="column is-4 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-danger-dark">A Resource or Site Head is Booked for today</th>
                                        </tr>
                                        @foreach($resourcesBooked as $user)
                                            <tr>
                                                <td style="text-align: center">
                                                    <a target="_blank" href="{{route('hidtory.user', $user->id)}}">{{ $user->name }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


