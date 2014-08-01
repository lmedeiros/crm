<?php

    $back_operation_id = array('id=' . $_GET['mailing_id'] => 99);

    $delete = new CreateDelete($back_operation_id, $_GET['lead_id']);
    $delete->delete("sp_sys_mailing_lead_delete");

?>
