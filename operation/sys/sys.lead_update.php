<?php
$back_operation_id = array('id='.$_GET['mailing_id']=>110);

    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '0') {
                return 'Yes';
        } elseif($value == '1') {
                return 'No';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION
    function getRecords() {
	$accounts = $GLOBALS['db']->selectAll("SELECT * FROM sys_lead_update L WHERE sys_mailing_lead_id = '" . @$_GET['lead_id'] . "' AND " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    function getSeller($value) {
	if($value==0) {
		return 'FREE';
	}
	
        $accounts = $GLOBALS['db']->selectRow("SELECT fullname FROM sys_seller S INNER JOIN fwk_user U ON U.fwk_user_id = S.fwk_user_id AND S.sys_seller_id = '" . $value . "'");
        if($accounts) {
            return $accounts['fullname'];
        } else {
            return false;
        }
    }

    $titles = $GLOBALS['db']->selectRow("SELECT * FROM sys_mailing WHERE sys_mailing_id='" . @$_GET['mailing_id'] . "'");
    
//    debug($titles); 

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Seller", "Date/Time", "Information","Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("sys_seller_id", "date_insert", "description", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(114);
    $actions_confirm = Array(114=>'Are you sure to delete?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        114 => array(
            "id" => "@sys_lead_update_id",
	    "lead_id" => "@sys_mailing_lead_id",
	    "mailing_id" => $_GET['mailing_id']
        )
    );

    # 5 - TABLE BUILD
    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getRecords(),'date_insert', 'ASC', 100);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_peer");
    $table->addFilter(0, "getSeller");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(0),$back_operation_id);
    $table->displayTable();



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
       new Field("textarea", "UPDATE", "description", "", "", "Tooltip text to show on mouse over", 80, true),
       new Field("text", $record['field1_name'], "field1_value", $record['field1_value'], "", "Field1 Name", 30, false),
       new Field("text", $record['field2_name'], "field2_value", $record['field2_value'], "", "Field2 Name", 30, false),
       new Field("text", $record['field3_name'], "field3_value", $record['field3_value'], "", "Field3 Name", 30, false),
       new Field("text", $record['field4_name'], "field4_value", $record['field4_value'], "", "Field4 Name", 30, false),
       new Field("text", $record['field5_name'], "field5_value", $record['field5_value'], "", "Field5 Name", 30, false),
       new Field("text", $record['field6_name'], "field6_value", $record['field6_value'], "", "Field6 Name", 30, false),
       new Field("text", $record['field7_name'], "field7_value", $record['field7_value'], "", "Field7 Name", 30, false),
       new Field("text", $record['field8_name'], "field8_value", $record['field8_value'], "", "Field8 Name", 30, false),
       new Field("hidden", "", "sys_seller_id", $record['sys_seller_id'], "", "", 0, true),
       new Field("hidden", "", "sys_mailing_leads_id", $_GET['lead_id'], "", "", 0, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields,false);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_sys_lead_update");
} else {
    $form->show_form();
}

?>
