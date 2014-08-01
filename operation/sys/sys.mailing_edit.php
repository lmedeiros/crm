<?php

$back_operation_id = 101;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM sys_mailing WHERE sys_mailing_id = {$_GET['id']}";
        $record = $GLOBALS['db']->selectAll($query);
        if(isset($record[0])) {
            return $record[0];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$record = load_values();
if(!$record){
    Header("Location: ?operation={$back_operation_id}");
} else {
    $fields = array(
       new Field("text", "Mailing name", "name", $record['description'] ,"", "Mailing name", 40, true),
       new Field("text", "Field 01", "field1_name", $record['field1_name'], "", "Field1 Name", 30, false),
       new Field("text", "Field 02", "field2_name", $record['field2_name'], "", "Field2 Name", 30, false),
       new Field("text", "Field 03", "field3_name", $record['field3_name'], "", "Field3 Name", 30, false),
       new Field("text", "Field 04", "field4_name", $record['field4_name'], "", "Field4 Name", 30, false),
       new Field("text", "Field 05", "field5_name", $record['field5_name'], "", "Field5 Name", 30, false),
       new Field("text", "Field 06", "field6_name", $record['field6_name'], "", "Field6 Name", 30, false),
       new Field("text", "Field 07", "field7_name", $record['field7_name'], "", "Field7 Name", 30, false),
       new Field("text", "Field 08", "field8_name", $record['field8_name'], "", "Field8 Name", 30, false),
       new Field("hidden", "", "sys_mailing_id", $_GET['id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_sys_mailing_update");
} else {
    $form->show_form();
}
?>

