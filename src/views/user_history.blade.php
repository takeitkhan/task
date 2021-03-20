@extends('layouts.app')
@section('title')
    User History
@endsection

@section('column_left')

    @php
        function getTotalForUser($userid, $getColumn, $checkColumn) {
            return $total_tasks = \Tritiyo\Task\Models\Task::where('site_head', $userid)
                ->leftJoin('tasks_requisition_bill', 'tasks_requisition_bill.task_id', 'tasks.id')
                ->select('tasks.*', 'tasks_requisition_bill.'. $getColumn .'')
                ->where('tasks_requisition_bill.'.$checkColumn.'', 'Yes')
                ->get();
        }
    @endphp

    <div class="columns is-vcentered  pt-2">
        <div class="column is-10 mx-auto">
            <div class="card tile is-child xquick_view">
                <header class="card-header">
                    <p class="card-header-title">
                    <span class="icon">
                        <i class="fas fa-tasks default"></i>
                    </span>
                        User History
                </header>

                <div class="card-content">
                    <div class="card-data">
                        @php
                            $user = \App\Models\User::where('id', $user_id)->first();
                        @endphp
                        <div class="columns">
                            <div class="column is-8">
                                <br/>
                                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <strong>Personal Information</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td>{{ $user->name }}</td>
                                        <td><strong>Email</strong></td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Employee No</strong></td>
                                        <td>{{ $user->employee_no }}</td>
                                        <td><strong>Username</strong></td>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Role</strong></td>
                                        <td>{{ \App\Models\Role::where('id', $user->role)->first()->name }}</td>
                                        <td><strong>Birthday</strong></td>
                                        <td>{{ $user->birthday }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender</strong></td>
                                        <td>{{ $user->gender }}</td>
                                        <td><strong>Marital Status</strong></td>
                                        <td>{{ $user->marital_status }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone No</strong></td>
                                        <td>{{ $user->phone }}</td>
                                        <td><strong>Phone No (Alternative)</strong></td>
                                        <td>{{ $user->emergency_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Basic Salary</strong></td>
                                        <td>{{ $user->basic_salary }}</td>
                                        <td><strong>Employee Status</strong></td>
                                        <td>{{ $user->employee_status ?? NULL }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Employee Status Note</strong></td>
                                        <td>{{ $user->employee_status_reason ?? NULL }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="column is-4">
                                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                    <tr>
                                        <td>
                                            @php
                                                $requisition_total = [];
                                            @endphp
                                            @foreach(getTotalForUser($user_id, 'requisition_edited_by_accountant', 'requisition_approved_by_accountant') as $task)
                                                @php
                                                    //dd($task);
                                                    $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id);
                                                    $requisition_total[] = $rm->getTotal();
                                                @endphp
                                            @endforeach

                                            <div class="notification is-warning has-text-centered">
                                                Requisition Approved <br/>
                                                <h1 class="title">
                                                    BDT. {{ array_sum($requisition_total) }}
                                                </h1>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php
                                                $bill_submitted = [];
                                            @endphp
                                            @foreach(getTotalForUser($user_id, 'bill_prepared_by_resource', 'bill_submitted_by_resource') as $task)
                                                @php
                                                    //dd($task);
                                                    $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_prepared_by_resource', $task->id);
                                                    $bill_submitted[] = $rm->getTotal();
                                                @endphp
                                            @endforeach
                                            <div class="notification is-link has-text-centered">
                                                Bill Submitted By Resource
                                                <h1 class="title">
                                                    BDT. {{ array_sum($bill_submitted) }}
                                                </h1>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php
                                                $bill_approved = [];
                                            @endphp
                                            @foreach(getTotalForUser($user_id, 'bill_edited_by_accountant', 'bill_approved_by_accountant') as $task)
                                                @php
                                                    //dd($task);
                                                    $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_edited_by_accountant', $task->id);
                                                    $bill_approved[] = $rm->getTotal();
                                                @endphp
                                            @endforeach
                                            <div class="notification is-success has-text-centered">
                                                Bill Approved
                                                <h1 class="title">
                                                    BDT. {{ array_sum($bill_approved) }}
                                                </h1>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


@endsection
