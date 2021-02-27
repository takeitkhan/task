<?php

namespace Tritiyo\Task\Helpers;

use Tritiyo\Task\Models\TaskStatus;

class TaskHelper
{

    public static function taskMessageHandler()
    {
        $task_statuses = array(
            'head_accepted' => array(
                'key' => 'head_accepted',
                'message' => 'Task accepted by site head'
            ),
            2 => array(
                'key' => 'proof_given',
                'message' => 'Task proof given by site head'
            ),
            'approver_approved' => array(
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

            'head_declined' => array(
                'key' => 'head_declined',
                'message' => 'Declined by site head'
            ),

            'task_approver_edited' => array(
                'key' => 'task_approver_edited',
                'message' => 'Task edited by approver'
            ),

            'approver_declined' => array(
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

    public static function getStatusKey($arg)
    {
        if (isset($arg)) {
            foreach (self::taskMessageHandler() as $key => $val) {
                if ($key == $arg) {
                    return $val['key'];
                }
            }
        }
    }

    public static function getStatusMessage($arg)
    {
        if (isset($arg)) {
            foreach (self::taskMessageHandler() as $key => $val) {
                if ($key == $arg) {
                    return $val['message'];
                }
            }
        }
    }


    public static function statusUpdate(array $options = array())
    {
        $default = [
            'code' => null,
            'task_id' => null,
            'action_performed_by' => null,
            'performed_for' => null,
            'requisition_id' => null,
            'message' => null
        ];

        $new = (object)array_merge($default, $options);

        $status_attributes = [
            'code' => $new->code,
            'task_id' => $new->task_id,
            'action_performed_by' => $new->action_performed_by,
            'performed_for' => $new->performed_for,
            'requisition_id' => $new->requisition_id,
            'message' => $new->message
        ];

        $taskstatus = TaskStatus::create($status_attributes);
        return $taskstatus;
    }


    public static function statusUpdateOrInsert(array $options = array())
    {

        //dd($options);

        $default = [
            'code' => null,
            'task_id' => null,
            'action_performed_by' => null,
            'performed_for' => null,
            'requisition_id' => null,
            'message' => null
        ];

        $new = (object)array_merge($default, $options);

        $status_attributes = [
            'code' => $new->code,
            'task_id' => $new->task_id,
            'action_performed_by' => $new->action_performed_by,
            'performed_for' => $new->performed_for,
            'requisition_id' => $new->requisition_id,
            'message' => $new->message
        ];
        //$taskstatus = TaskStatus::create($status_attributes);

        $taskstatus = TaskStatus::updateOrCreate(
            $status_attributes
        );
        return $taskstatus;
    }


    public static function buttonInputApproveDecline($approve, $decline){
        
        $html = '<input type="hidden" name="accept[]" value="'.$approve.'" class="button is-success"/>';
        $html .= '<input type="submit" name="accept[]" value="Approve" class="button is-success"/>';
        $html .= '<input type="hidden" name="decline[]" value="'.$decline.'" class="button is-danger"/>';
        $html .= '<input type="submit" name="decline[]" value="Decline" class="button is-danger"/>';
        return $html;
    }

}


