<?php
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
	$accounts = $GLOBALS['db']->selectAll("SELECT DISTINCT M.* FROM sys_mailing M INNER JOIN sys_mailing_lead L ON L.sys_seller_id = '" . $_SESSION[session_key] . "' AND L.sys_mailing_id = M.sys_mailing_id AND " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }

    function getClean($value) {
	$accounts = $GLOBALS['db']->selectRow("SELECT count(L.sys_mailing_id) as tot FROM sys_mailing_lead L WHERE L.sys_mailing_id='{$value}' AND L.sys_seller_id='" . $_SESSION[session_key] . "'");
	       if($accounts) {
            return $accounts['tot'];
        } else {
            return false;
        }
    }
    
     function getAll($value) {
        $accounts = $GLOBALS['db']->selectRow("SELECT count(L.sys_mailing_id) as tot FROM sys_mailing_lead L WHERE L.sys_mailing_id='{$value}'");
               if($accounts) {
            return $accounts['tot'];
        } else {
            return false;
        }
    }

   function getWorked($value) {
        $accounts = $GLOBALS['db']->selectRow("SELECT count(L.sys_mailing_id) as tot FROM sys_mailing_lead L WHERE L.sys_mailing_id='{$value}' AND L.is_worked=1 AND L.sys_seller_id='" . $_SESSION[session_key] . "'");
               if($accounts) {
            return $accounts['tot'];
        } else {
            return false;
        }
    }

    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Description", "Filename", "Loaded on" , "My Leads" , "My Worked Leads","Total Leads","Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("description", "filename", "date_insert", "sys_mailing_id", "sys_mailing_id", "sys_mailing_id","ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(110);
    $actions_confirm = Array(95=>'Are you sure to delete?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        110 => array(
            "id" => "@sys_mailing_id"
        )

    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getRecords(),'date_insert', 'ASC', 20);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_peer");
    $table->setActionsParameters($action_parameters);
    $table->addFilter(3, "getClean");
    $table->addFilter(4, "getWorked");
    $table->addFilter(5, "getAll");
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
    new CreateHome(@$_GET['operation'], array(0),0);
    $table->displayTable();
?>

