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
	$accounts = $GLOBALS['db']->selectAll("SELECT S.sys_seller_id, S.fwk_user_id, U.fullname, U.email, S.score FROM sys_seller S INNER JOIN fwk_user U ON U.fwk_user_id = S.fwk_user_id WHERE " . query_filter());
        if($accounts) {
            return $accounts;
        } else {
            return false;
        }
    }
    
    # 4 - LIST TABLE CONFIG
    #$headers column names
    $headers = array("Description", "E-mail", "Score" ,"Actions");
    #$columns database column names, or parameter for the Filter Function
    $columns = array("fullname", "email", "score", "ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(106, 104);
    $actions_confirm = Array(104=>'Are you sure to delete?');
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        106 => array(
            "id" => "@sys_seller_id"
        ),
	// Edit Seller
        //105 => array(
        //    "id" => "@sys_seller_id"
    	//),    
	104 => array(
	    "id" => "@sys_seller_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getRecords(),'fullname', 'ASC', 20);

    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(1, "get_peer");
    //$table->addFilter(4, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    $table->addConfirmActions($actions_confirm);
    #show tables
	    new CreateHome(@$_GET['operation'], array(102),0);
    $table->displayTable();
?>

