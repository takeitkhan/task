<?php


namespace Tritiyo\Task\Helpers;


class RequisitionHelper
{


    public static function requisitionMessageHandler()
    {
        $task_statuses = array(
            'da' => array(
                'key' => 'da_amount',
                'message' => 'Task accepted by site head'
            ),
            'ta' => array(
                'key' => 'proof_given',
                'message' => 'Task proof given by site head'
            ),
            3 => array(
                'key' => 'approver_approved',
                'message' => 'Task approved by approver'
            ),
            'requisition_placed' => array(
                'key' => 'requisition_placed',
                'message' => 'Requisition placed by manager',
            ),
            'cfo_requisition_approved' => array(
                'key' => 'cfo_requisition_approved',
                'message' => 'Requisition approved by CFO'
            ),
            'accountant_sent' => array(
                'key' => 'accountant_sent',
                'message' => 'Requisition approved by accountant'
            ),
            'bill_submitted_by_resource' => array(
                'key' => 'bill_submitted_by_resource',
                'message' => 'Bill submitted by resource'
            ),
            'manager_bill_approved' => array(
                'key' => 'manager_bill_approved',
                'message' => 'Bill approved by manager'
            ),
            'cfo_bill_approved' => array(
                'key' => 'cfo_bill_approved',
                'message' => 'Bill approved by CFO'
            ),
            'accountant_bill_approved' => array(
                'key' => 'accountant_bill_approved',
                'message' => 'Bill approved by accountant'
            ),

            11 => array(
                'key' => 'head_declined',
                'message' => 'Declined by site head'
            ),

            'task_approver_edited' => array(
                'key' => 'task_approver_edited',
                'message' => 'Task edited by approver'
            ),

            13 => array(
                'key' => 'approver_declined',
                'message' => 'Declined by approver'
            ),
            'cfo_requisition_declined' => array(
                'key' => 'cfo_requisition_declined',
                'message' => 'Requisition declined by CFO'
            ),
            'accountant_requisition_declined' => array(
                'key' => 'accountant_requisition_declined',
                'message' => 'Requisition declined by accountant'
            ),

            'task_assigned_to_head' => array(
                'key' => 'task_assigned_to_head',
                'message' => 'Task assigned to head'
            ),

        );

        return $task_statuses;
    }

}
