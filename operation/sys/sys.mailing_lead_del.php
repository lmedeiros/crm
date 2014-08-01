<?php

    $back_operation_id = array('id=' . $_GET['mailing_id'] . '&user_id=' . $_GET['seller_id'] =>111);

    $delete = new CreateDelete($back_operation_id, $_GET['lead_id']);
    $delete->delete("sp_sys_mailing_lead_delete");

?>
