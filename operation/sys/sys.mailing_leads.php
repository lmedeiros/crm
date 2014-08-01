<?php
    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '1') {
                return 'Yes';
        } elseif($value == '0') {
                return 'No';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION
    function getRecords() {
	$accounts = $GLOBALS['db']->selectAll("SELECT L.* FROM sys_mailing_lead L WHERE sys_mailing_id = '" . @$_GET['id'] . "' AND " . query_filter());
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

    $titles = $GLOBALS['db']->selectRow("SELECT * FROM sys_mailing WHERE sys_mailing_id='" . @$_GET['id'] . "'");
    
//    debug($titles); 

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array(
		$titles['field1_name'],
		$titles['field2_name'],
		$titles['field3_name'],
 		$titles['field4_name'],
 		$titles['field5_name'],
		$titles['field6_name'],
	       	$titles['field7_name'],
		$titles['field8_name'],
		"Seller",
		"Has Updates?",
		"Actions"
		);
    #$columns database column names, or parameter for the Filter Function
    $columns = array("field1_value", "field2_value", "field3_value", "field4_value", "field5_value", "field6_value", "field7_value", "field8_value","sys_seller_id", "is_worked","ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(98, 115, 116);
    $actions_confirm = Array(115=>'Are you sure to delete?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        98 => array(
            "lead_id" => "@sys_mailing_leads_id",
            "mailing_id" => "@sys_mailing_id"
	),
	115 => array(
            "lead_id" => "@sys_mailing_leads_id",
	    "mailing_id" => "@sys_mailing_id"
        ),
        116 => array(
            "lead_id" => "@sys_mailing_leads_id",
            "mailing_id" => "@sys_mailing_id",
	    "seller_id" => "@sys_seller_id"
	),

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
    $table->addFilter(8, "getSeller");
    $table->addFilter(9, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
	    new CreateHome(@$_GET['operation'], array(96),101);
    $table->displayTable();
?>
