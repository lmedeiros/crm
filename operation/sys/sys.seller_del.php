<?php

    $back_operation_id = 107;

    $delete = new CreateDelete($back_operation_id, $_GET['id']);
    $delete->delete("sp_sys_seller_delete");

?>

