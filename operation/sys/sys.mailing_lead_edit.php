<?php
$back_operation_id = array('id='.$_GET['mailing_id']=>99);

function load_values() {
    if (isset($_GET['lead_id']) && $_GET['lead_id'] != "") {
        $query = "SELECT * FROM sys_mailing_lead L INNER JOIN sys_mailing M ON M.sys_mailing_id = L.sys_mailing_id AND L.sys_mailing_leads_id = {$_GET['lead_id']}";
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
//    Header("Location: ?operation={$back_operation_id}");
} else {
    $fields = array(
       new Field("text", $record['field1_name'], "field1_value", $record['field1_value'], "", "Field1 Name", 30, false),
       new Field("text", $record['field2_name'], "field2_value", $record['field2_value'], "", "Field2 Name", 30, false),
       new Field("text", $record['field3_name'], "field3_value", $record['field3_value'], "", "Field3 Name", 30, false),
       new Field("text", $record['field4_name'], "field4_value", $record['field4_value'], "", "Field4 Name", 30, false),
       new Field("text", $record['field5_name'], "field5_value", $record['field5_value'], "", "Field5 Name", 30, false),
       new Field("text", $record['field6_name'], "field6_value", $record['field6_value'], "", "Field6 Name", 30, false),
       new Field("text", $record['field7_name'], "field7_value", $record['field7_value'], "", "Field7 Name", 30, false),
       new Field("text", $record['field8_name'], "field8_value", $record['field8_value'], "", "Field8 Name", 30, false),
       new Field("hidden", "", "sys_mailing_leads_id", $_GET['lead_id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_sys_lead_edit");
} else {
    $form->show_form();
}

?>

