<?php
    # 1 - CLASS INCLUDES
    require("framework/fwk.table.php");

    # 2 - FILTER FUNCTIONS
    function filterBoolean($value) {
        if($value == '0') {
                return 'Não';
        } elseif($value == '1') {
                return 'Sim';
        }
        return 'Unknown';
    }

    # 3 - RECORDSET FUNCTION
    function getUser() {
        $users = $GLOBALS['db']->selectAll("SELECT * FROM pbx_locker");
        if($users) {
            return $users;
        } else {
            return false;
        }
    }
    # 4 - LIST TABLE CONFIG

        #$headers column names
        $headers = array("Descrição","Senha", "Ativo?","Actions");

        #$columns database column names, or parameter for the Filter Function
        $columns = array("description", "pbx_locker_id", 'is_active',"ACTIONS");
    #$actions array of operations ID related to the page type LIST
    $actions = array(77);
    #$action_parameters _GET parameters to the functions related, key = GET name, value = @database field
    $action_parameters = array(
        77 => array(
            "id" => "@pbx_locker_id"
        )
    );

    # 5 - TABLE BUILD

    #populate table 1arg - List Title, 2arg - Function which returns data recordset
    $table = new DisplayTable(getUser(),'description', 'ASC');

    
    #set table header column names
    $table->setHeaders($headers);
    #set table database columns
    $table->setColumns($columns);
    #NO data message
    $table->setEmptyMessage("There is no rate groups.");
    #add value filter, 1st arg = database column array index, 2arg = filter function name
    //$table->addFilter(2, "filterSys_user_id");
    $table->addFilter(2, "filterBoolean");
    $table->setActionsParameters($action_parameters);
    #set table list actions and parameters
    $table->setActions($actions);
    #show tables
    new CreateHome(@$_GET['operation'], array(76), 53);
    $table->displayTable();
?>