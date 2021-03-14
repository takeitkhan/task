<?php


namespace Tritiyo\Task\Helpers;

use Tritiyo\Task\Models\TaskRequisitionBill;

class RequisitionData
{

    protected $column;
    protected $task_id;

    public function __construct($column, $task_id)
    {
        $this->column = $column;
        $this->task_id = $task_id;
        //dd($task_id);
    }

    public function getTotal()
    {
        $in_total = $this->getRegularTotal() + $this->getVehicleTotal() + $this->getMaterialTotal() + $this->getTransportTotal() + $this->getPurchaseTotal();
        return $in_total;
    }

    public function getSiteHead()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return $extracted->task[0]->site_head;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function getVehicleData()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return $extracted->task_vehicle;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getVehicleTotal()
    {
//        $chunk = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
//        $extracted = (object)json_decode($chunk->requisition_prepared_by_manager);
//        return $extracted->task_vehicle;
    }

    public function getRegularTotal()
    {

    }

    public function getRegularData()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return (array)$extracted->task_regular_amount;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMaterialTotal()
    {

    }

    public function getMaterialData()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return $extracted->task_material;
            } else {
                return false;
            }
        }else {
            return false;
        }
    }


    public function getTransportTotal()
    {

    }

    public function getTransportData()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return $extracted->task_transport_breakdown;
            } else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function getPurchaseTotal()
    {

    }

    public function getPurchaseData()
    {
        $v = TaskRequisitionBill::select($this->column)->where('task_id', $this->task_id)->first();
        if(!empty($v)) {
            $chunk = $v->toArray();
            if (!empty($chunk)) {
                $extracted = (object)json_decode($chunk[$this->column]);
                return $extracted->task_purchase_breakdown;
            } else {
                return false;
            }
        }else {
            return false;
        }
    }


//array_sum(array_map(function($item) {
//    return $item['f_count'];
//}, $arr));
}
