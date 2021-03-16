<?php


namespace Tritiyo\Task\Helpers;


use Tritiyo\Task\Models\TaskRequisitionBill;
use DB;

class SiteHeadTotal
{

    protected $column;
    protected $site_head_id;

    public function __construct($column, $site_head_id)
    {
        $this->column = $column;
        $this->site_head = $site_head_id;
        //dd($task_id);
    }


    public function getTotal()
    {
        $in_total = $this->getRegularTotal() + $this->getVehicleTotal() + $this->getMaterialTotal() + $this->getTransportTotal() + $this->getPurchaseTotal();
        return $in_total;
    }

    public function getVehicleTotal()
    {
        $vehicle_rent = DB::select("SELECT sum(vehicle_rent) AS vehicle_rent_total FROM tasks_requisition_bill, JSON_TABLE(requisition_edited_by_accountant, '$.task_vehicle[*]' COLUMNS (vehicle_rent VARCHAR(255) PATH '$.vehicle_rent')) task_vehicle WHERE tasks_requisition_bill.task_id = 1");

        return $vehicle_rent[0]->vehicle_rent_total;
    }

    public function getMaterialTotal()
    {
        $material_amount = DB::select("SELECT sum(material_total_amount) AS material_total FROM tasks_requisition_bill, JSON_TABLE(requisition_edited_by_accountant, '$.task_material[*]' COLUMNS (material_total_amount VARCHAR(255) PATH '$.material_amount')) task_material WHERE tasks_requisition_bill.task_id = 1");

        return $material_amount[0]->material_total;
    }


    public function getRegularTotal()
    {
        return 0;
    }


    public function getTransportTotal()
    {
        return 0;
    }

    public function getPurchaseTotal()
    {
        return 0;
    }


    /**
     * SELECT vehicle_rent->>'$.vehicle_rent', material_amount->>'$.material_amount' FROM (
     * SELECT
     * JSON_OBJECT('vehicle_rent', JSON_EXTRACT(`requisition_edited_by_accountant` , '$.task_vehicle[0].vehicle_rent') ) as vehicle_rent,
     * JSON_OBJECT('material_amount',JSON_EXTRACT(`requisition_edited_by_accountant`
     * , '$.task_material[0].material_amount')) as material_amount
     *
     * FROM `tasks_requisition_bill`
     * WHERE task_id = 1
     * ) AS total
     *
     *
     */

}
