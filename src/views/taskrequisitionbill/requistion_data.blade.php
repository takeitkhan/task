<?php
global $taskID;
$taskID = $task->id;
global $getData;
$getData = \Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $taskID)->get()->toArray();
function requisitiomData($column, $person){
    global $taskID;
    global $getData;
    $rd = new \Tritiyo\Task\Helpers\RequisitionData($column, $taskID);
    //$arr = $rd->getSiteHead();

    $vehicle = $rd->getVehicleData();
    $material = $rd->getMaterialData();
    $regular = $rd->getRegularData();
    //dump($regular);

    $transport = $rd->getTransportData();
    //dump($transport);
    global $purchase;
    $purchase = $rd->getPurchaseData();
    ob_start();
    $totalAmount = 0;
?>
<?php //dd($vehicle);?>
    @if(is_array($vehicle))
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <tr>
            <th colspan="3">Vehicle Information</th>
        </tr>
        <tr>
            <th width="15%">Vehicle</th>
            <th>Note</th>
            <th width="30%">Vehicle Rent</th>
        </tr>
        @php
            $vehicle_sum = array();
            $i = 0;
        @endphp
        <?php foreach($vehicle as $v){?>
        <tr>
            <td>{{ $v->vehicle_id }}</td>
            <td>{{ $v->vehicle_note }}</td>
            <td>{{ $vehicle_sum[$i] = $v->vehicle_rent }}</td>
        </tr>
        @php
            $i++;
        @endphp
        <?php } ?>
        @php
            $total_vehicle_rent = array_sum($vehicle_sum);
        @endphp
        <tr>
            <td colspan="2">Total</td>
            <td>{{ $total_vehicle_rent }}</td>
            <?php $totalAmount += $total_vehicle_rent;?>
        </tr>
    </table>
    @endif
    @if(is_array($material))
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <tr class="">
            <th colspan="4">Material Information</th>
        </tr>
        <tr>
            <th width="15%">Material</th>
            <th width="5%">Qty.</th>
            <th>Note</th>
            <th width="30%">Material Amount</th>
        </tr>

        @php
            $material_sum = array();
            $i = 0;
        @endphp
        <?php foreach($material as $m){?>
        <tr>
            <td>{{ $m->material_id }}</td>
            <td>{{ $m->material_qty }}</td>
            <td>{{ $m->material_note }}</td>
            <td>{{ $material_sum[$i] = $m->material_amount }}</td>
        </tr>
        @php
            $i++;
        @endphp
        <?php } ?>
        @php
            $total_material_amount = array_sum($material_sum);
        @endphp
        <tr>
            <td colspan="3">Total</td>
            <td>{{ $total_material_amount }}</td>
            <?php $totalAmount += $total_material_amount;?>
        </tr>
    </table>
    @endif
    @if(is_array($regular))
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
    <tr class="">
        <th width="20%">Regular </th>
        <th width="50%">Note </th>
        <th width="30%">Amount </th>
    </tr>
    <tr>
        <td>DA</td>
        <td>{{$regular['da']->da_notes}}</td>
        <td>{{$regular['da']->da_amount}}</td>
    </tr>
    <tr>
        <td>labour</td>
        <td>{{$regular['labour']->labour_notes}}</td>
        <td>{{ $regular['labour']->labour_amount}}</td>
    </tr>
    <tr>
        <td>Other</td>
        <td>{{$regular['other']->other_notes}}</td>
        <td>{{$regular['other']->other_amount}}</td>
    </tr>

    <tr>
        <td colspan="2">Total</td>
        <td>{{$regularAmount = $regular['da']->da_amount + $regular['labour']->labour_amount + $regular['other']->other_amount}}</td>
        <?php $totalAmount += $regularAmount;?>

    </tr>


</table>
    @endif
    @if(is_array($transport))
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <tr class="">
            <th colspan="4">Transport Information</th>
        </tr>
        <tr>
            <th width="15%">Where To Where</th>
            <th width="5%">Transport Type</th>
            <th>Note</th>
            <th width="30%">Transport Amount</th>
        </tr>

        @php
            $ta_sum = array();
            $i = 0;
        @endphp
        <?php foreach($transport as $t){?>
        <tr>
            <td>{{ $t->where_to_where }}</td>
            <td>{{ $t->transport_type }}</td>
            <td>{{ $t->ta_note }}</td>
            <td>{{ $ta_sum[$i] = $t->ta_amount }}</td>
        </tr>
        @php
            $i++;
        @endphp
        <?php } ?>
        @php
            $total_transport_amount = array_sum($ta_sum);
        @endphp
        <tr>
            <td colspan="3">Total</td>
            <td>{{ $total_transport_amount }}</td>
            <?php $totalAmount += $total_transport_amount;?>
        </tr>
    </table>
    @endif
    @if(is_array($purchase))
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <tr class="">
            <th colspan="4">Purchase Information</th>
        </tr>
        <tr>
            <th width="70%">Note</th>
            <th width="30%">Purchase Amount</th>
        </tr>

        @php
            $pa_sum = array();
            $i = 0;
        @endphp
        <?php foreach($purchase as $p){?>
        <tr>
            <td>{{ $p->pa_note }}</td>
            <td>{{ $pa_sum[$i] = $p->pa_amount }}</td>
        </tr>
        @php
            $i++;
        @endphp
        <?php } ?>
        @php
            $total_purchase_amount = array_sum($pa_sum);
        @endphp
        <tr>
            <td colspan="1">Total</td>
            <td>{{ $total_purchase_amount }}</td>
            <?php $totalAmount += $total_purchase_amount;?>
        </tr>
        <br/>
    </table>
    @endif
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <tr>
            <th width="70%">{{$person}} edited in total</th>
            <th width="30%"><?php echo $totalAmount;?></th>
        </tr>
    </table>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>
<?php //dd($getData) ;?>
@if(is_array($getData))
    @if (auth()->user()->isResource(auth()->user()->id))

    @else

        <div class="card tile is-child quick_view">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Requisition Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="tabs is-centered is-boxed is-small" id="requisition_tabs">
                    <ul>
                        <li class="is-active" data-requisition="1">
                            <a>
                                <span>Manager Submitted</span>
                            </a>
                        </li>
                        <li data-requisition="2">
                            <a>
                                <span>CFO Edited</span>
                            </a>
                        </li>
                        <li data-requisition="3">
                            <a>
                                <span>Accountant Disbursed</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="requisition-tab-content">

                    <div class="is-active" data-rcontent="1">
                      <?php echo requisitiomData('requisition_prepared_by_manager', 'Manager');?>
                    </div>

                    <div data-rcontent="2">
                        <?php echo requisitiomData('requisition_edited_by_cfo', 'CFO');?>
                    </div>
                    <div data-rcontent="3">
                        <?php echo requisitiomData('requisition_edited_by_accountant', 'Accountant');?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endif

    <div class="card tile is-child quick_view">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                 Bill Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="tabs is-centered is-boxed is-small" id="bill_tabs">
                    <ul>
                        <li class="is-active" data-bill="1">
                            <a>
                                <span>Resource Submitted</span>
                            </a>
                        </li>
                        <li data-bill="2">
                            <a>
                                <span>Manager Edited</span>
                            </a>
                        </li>
                        <li data-bill="3">
                            <a>
                                <span>CFO Edited</span>
                            </a>
                        </li>
                        <li data-bill="4">
                            <a>
                                <span>Accountant Disbursed</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="bill-tab-content">

                    <div class="is-active" data-bcontent="1">
                        <?php echo requisitiomData('bill_prepared_by_resource', 'Resource');?>
                    </div>

                    <div data-bcontent="2">
                        <?php echo requisitiomData('bill_edited_by_manager', 'Manager');?>
                    </div>
                    <div data-bcontent="3">
                        <?php echo requisitiomData('bill_edited_by_cfo', 'CFO');?>
                    </div>
                    <div data-bcontent="4">
                        <?php echo requisitiomData('bill_edited_by_accountant', 'Accountant');?>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif




@section('headjs')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style type="text/css">
        .tile.is-child.quick_view {
            margin-top: 15px !important;
        }

        .quick_view, .quick_view table {
            font-size: 12px;
        }

        .quick_view table th {
            color: darkblue;
        }

        #requisition-tab-content div {
            display: none;
        }

        #requisition-tab-content div.is-active {
            display: block;
        }

        #bill-tab-content div {
            display: none;
        }

        #bill-tab-content div.is-active {
            display: block;
        }

    </style>

@endsection
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.noConflict();

        $('#requisition_tabs li').on('click', function () {
            var requisition = $(this).data('requisition');

            $('#requisition_tabs li').removeClass('is-active');
            $(this).addClass('is-active');

            $('#requisition-tab-content div').removeClass('is-active');
            $('div[data-rcontent="' + requisition + '"]').addClass('is-active');
        });

        $('#bill_tabs li').on('click', function () {
            var bill = $(this).data('bill');

            $('#bill_tabs li').removeClass('is-active');
            $(this).addClass('is-active');

            $('#bill-tab-content div').removeClass('is-active');
            $('div[data-bcontent="' + bill + '"]').addClass('is-active');
        });
    });
</script>