<?php

    $back_operation_id = 101;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_sys_mailing_delete");

?>

