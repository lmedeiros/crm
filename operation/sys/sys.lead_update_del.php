<?php

    $back_operation_id = array('lead_id=' . $_GET['lead_id'] . '&mailing_id=' . $_GET['mailing_id']=>112);

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_sys_lead_update_delete");

?>

