@extends('layouts.app')
@section('title')
   User History
@endsection

@section('column_left')

<div class="columns is-vcentered  pt-2">
    <div class="column is-10 mx-auto">
        <div class="card tile is-child xquick_view">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                        User 
            </header>

            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">

                        <tr>
                            <td>
                                <div class="notification is-warning has-text-centered">                                    
                                    Budget <br/>
                                    <h1 class="title">                                        
                                        BDT. 25000
                                    </h1>
                                  </div>
                            </td>
                            <td>
                                <div class="notification is-link has-text-centered">
                                    Bill Submitted
                                    <h1 class="title">
                                        BDT. 20000
                                    </h1>
                                  </div>
                            </td>
                            <td>
                                <div class="notification is-success has-text-centered">
                                    Bill Approved
                                    <h1 class="title">
                                        BDT. 18000
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


@endsection