<?php


namespace Tritiyo\Task\Helpers;


class RequisitionBillHelper
{


    public static function requisitionBillActionHelper(array $options = array())
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

        //$approve_key, $decline_key = false, $showOrNot = false


        $html = '<form action="" method="post">';
        $html .= csrf_field();
        $html .= '<input type="hidden" name="accept[]" value="Yes"/>';
        $html .= '<input type="hidden" name="accept[]" value="' . $approve_key . '"/>';
        $html .= '<input type="submit" name="accept[]" value="Approve" class="button is-success"/>';

        if ($showOrNot == true) {
            $html .= '<input type="hidden" name="decline[]" value="No"/>';
            $html .= '<input type="hidden" name="decline[]" value="' . $decline_key . '"/>';
            $html .= '<input type="submit" name="decline[]" value="Decline" class="button is-danger"/>';
        }
        $html .= '</form>';
        return $html;
    }

}
